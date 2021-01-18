#!/home/lusajo/anaconda3/bin/python

import socket
from southId import process

s = socket.socket()

try:
    s.bind(('',143))
    s.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
    s.listen(1)
except:
    print('failed')


while True:
    con, addr = s.accept()

    msg = con.recv(1024).decode('utf-8')
    msg = msg.split('###')

    if msg[0] == 'Done':
        ext = msg[1]
        print(ext)
        process(con,ext)
    else:
        print(msg)
        print('eeee')
