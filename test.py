import os
import threading
from twilio.rest import Client
from twilio.twiml.voice_response import VoiceResponse

account_sid = 'Axxxxxxxxxxx'
auth_token = 'rxxxxxxxxxxxx'

client = Client(account_sid, auth_token)

def sendSMS(number):
    call = client.calls.create(
        to=number,
        from_="+1000000000000",
        url="http://demo.twilio.com/docs/voice.xml"
    )
    print(call.sid)

with open('t.txt') as stream:
    for line in stream:
        cThread = threading.Thread(target=sendSMS, args=(line.strip(),))
        cThread.start()
  
