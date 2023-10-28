import os
import configparser
import sys

config = configparser.ConfigParser()
config.read('config.ini')

api_ip = config.get('api', 'ip')
api_port = config.get('api', 'port')

web_ip = config.get('web', 'ip')
web_port = config.get('web', 'port')

os.environ['RETRO_YT_API_IP'] = api_ip
os.environ['RETRO_YT_API_PORT'] = api_port

if len(sys.argv) > 1:
    if sys.argv[1] == '--api-only':
        os.system('npm start --prefix api')
    elif sys.argv[1] == '--web-only':
        os.system('php -S ' + web_ip + ':' + web_ip + ' -t web')
    else:
        print('Invalid argument')
        exit()
else:
    if os.name == 'nt':
        os.system('start cmd /k php -S ' + web_ip + ':' + web_port + ' -t web & start cmd /k npm start --prefix api')
    else:
        os.system('php -S ' + web_ip + ':' + web_port + ' -t web & npm start --prefix api')