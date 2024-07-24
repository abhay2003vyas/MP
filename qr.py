import qrcode
import json
import urllib.parse

# Sample data
data = {
    "Monitor no": "BITW/MONTR-172/2018-2019",
    "Department": "Computer Engineering",
    "Location": "OOPJ Lab - 2nd Floor"
}

# Convert data to JSON string
qr_data = json.dumps(data)

# Construct the redirect URL with encoded data
redirect_url = "http://bitmms.kesug.com/electrical.php?"
encoded_data = urllib.parse.urlencode({'qrdata': qr_data})
full_url = redirect_url + encoded_data

# Generate QR code
qr = qrcode.QRCode(
    version=1,
    error_correction=qrcode.constants.ERROR_CORRECT_L,
    box_size=10,
    border=4,
)
qr.add_data(full_url)
qr.make(fit=True)

# Create an image from the QR code data
img = qr.make_image(fill_color="black", back_color="white")

# Save the QR code image to a file
img.save("qr_code_monitor_info.png")

print("QR code with monitor information generated and saved as qr_code_monitor_info.png")
