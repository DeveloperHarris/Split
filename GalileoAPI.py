import requests
from xml.dom.minidom import parseString
import string
import random


# API credentials common to each call to Galileo API
apiLogin = 'yvK6Vd-9999'
apiTransKey = 'AEYqF2DrAv'
providerId = '432'
prodId = '5094'


payload = {

'apiLogin':apiLogin,
'apiTransKey':apiTransKey,
'providerId':providerId,
'transactionId':'30323-random-string-86881'

}

r = requests.post('https://sandbox-api.gpsrv.com/intserv/4.0/ping', data=payload, cert='mycert.pem')

dom = parseString(r.text)
statusCode = dom.getElementsByTagName('status_code')

print('ping response code=' + statusCode[0].firstChild.nodeValue)

