# south-africa-id-scanner
This simple code uses python to scan text from images of south africa id.
Text extracted are: Card id, Surname, Forenames, Country, Date of Birth and Date issued.

It uses web technology in the client side and php with python in backend.

How Code works

Php is responsible for accepting image from the browser and uploading it to the uploads directory. Then a notification is sent to python through socket to notify the image is ready for processing.

Python extracts Card id from the bar code and the rest of information is extracted using pytesseract library then filtered by regex.

The results are jsonfied then sent to Php to display them of the client side.
