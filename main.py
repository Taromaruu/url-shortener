from flask import Flask
import requests

app = Flask('app')

@app.route('/')
def main():
  return 'Hello, World!'

app.run(host='0.0.0.0', port=8080)