from rembg.bg import remove
import numpy as np
from PIL import Image
from PIL import ImageFile
import os
import sys
import base64
from io import StringIO
import io

input_path = sys.argv[1]
#input_path = os.path.abspath('rembg-main/image.jpg')
output_path = os.path.abspath('rembg-main/output.png')
#input_path = os.path.abspath('image.jpg')
#output_path = os.path.abspath('output.png')

# Uncomment the following line if working with trucated image formats (ex. JPEG / JPG)
ImageFile.LOAD_TRUNCATED_IMAGES = True

f = np.fromfile(input_path)
result = remove(f)
img = Image.open(io.BytesIO(result)).convert("RGBA")
img.save(output_path)

with open(output_path, "rb") as img_file:
    my_string = base64.b64encode(img_file.read())


print(my_string)
