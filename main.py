from flask import Flask, render_template, request, redirect, send_from_directory
import requests, random, os

url = 'https://ethereous-bead.000webhostapp.com/'

def make_identifier(length: int):
    return ''.join(random.choice("abcdefghjkmnopqrstuvwxyzABCDEFGHJKMNOPQRSTUVWXYZ") for i in range(length))

app = Flask(__name__)

@app.route('/', methods=['GET', 'POST'])
def main():
    if request.method == 'POST':
        if request.form['submit_button'] == 'Shorten!':
            identifier = make_identifier(5)
            params = {
                'method': 'post',
                'identifier': identifier,
                'url': request.form['url']
            }
            response = requests.get(url, params=params).json()

            if response['success'] == "false":
                return redirect(f"/?e=true&msg={response['error']}&inputurl={request.form['url']}")
            else:
                return redirect(f"/?s=true&url=https://dogshort.ml/{identifier}")
    elif request.method == 'GET':
        return render_template('index.html')

@app.route('/<identifier>')
def identifier_web(identifier):
    params = {
        'method': 'get',
        'identifier': identifier
    }
    response = requests.get(url, params=params).json()

    if response['success'] == "false":
        return f"https://dogshort.ml/{identifier} is not a valid url! You can make a shortened url <a href=\"https://dogshort.ml/\">here</a>"
    else:
        return redirect(response['url'])

@app.route('/favicon.ico')
def favicon():
    return send_from_directory(os.path.join(app.root_path, 'static'), 'favicon.ico', mimetype='image/vnd.microsoft.icon')

app.run(host='0.0.0.0', port=8080)