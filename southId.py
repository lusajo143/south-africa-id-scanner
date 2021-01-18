#!/home/lusajo/anaconda3/bin/python

from PIL import Image
import pytesseract
import json
from pyzbar import pyzbar as bar
import cv2

import re


def process(con,ext):

    data = pytesseract.image_to_string(Image.open('uploads/image.'+str(ext)))

    with open('q.txt','w') as p:
        p.write(data)

    with open('q.txt','r') as p:
        dr = p.read()

    country = ''
    sirname = ''
    forename = ''
    dob = ''

    cCount = 0
    sCount = 0
    fCount = 0
    fDob = 0

    with open('q.txt','r') as p:
        for line in p:

            res = re.search('COUNTRY OF BIRTH',line.strip())
            if line.strip() == '':
                continue
            if cCount == 1:
                country = line.strip()
                cCount = 0
            if res != None:
                cCount = 1

            sir = re.search('SURNAME',line.strip())
            if sCount == 1:
                sirname1 = line.strip()
                sirname1 = re.findall('[A-Z].*[A-Z]',sirname1)
                sirname = sirname1[0]
                sCount = 0
            if sir != None:
                sCount = 1

            fore = re.findall('FORENAMES',line.strip())
            if fCount == 1:
                forename = line.strip()
                fCount = 0
            if fore != []:
                fCount = 1

        



    d = re.findall('[0-9][0-9][0-9][0-9]-[0-9][0-9]-[0-9][0-9]',dr)

    '''
    Scan the id from bar code
    '''

    objects = bar.decode(cv2.imread('uploads/image.'+str(ext)))
    
    for obj in objects:
        id_ = obj.data.decode()

    try:
        dict_ = {
                'id_':id_,
                'Surname':sirname,
                'Forenames':forename,
                'Country':country,
                'DOB':d[0],
                'DI':d[1]
                }
        print(json.dumps(dict_))
        con.send(str(json.dumps(dict_)).encode())
    except Exception as e:
        con.send(b'Error')

    print('*****************************')
    print('********** Results **********')
    print('*****************************')
    print('Surname:',sirname)
    print('Forenames:',forename)
    print('Country:',country)
    print('Date of Birth:',d[0])
    print('Date Issued:',d[1],'\n')

if __name__ == "__main__":
    process()
