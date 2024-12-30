


import cv2
import http.client
import base64
import os

# Function to capture an image using the webcam
def capture_image(file_name="captured_image.jpg"):
    cap = cv2.VideoCapture(0)

    if not cap.isOpened():
        print("Could not open webcam.")
        return None

    print("Press 's' to save the image or 'q' to quit.")

    while True:
        ret, frame = cap.read()
        if not ret:
            print("Failed to capture frame.")
            break

        # Display the live feed
        cv2.imshow("Webcam", frame)

        # Wait for user input
        key = cv2.waitKey(1) & 0xFF
        if key == ord('s'):
            # Save the image
            cv2.imwrite(file_name, frame)
            print(f"Image saved as '{file_name}'")
            break
        elif key == ord('q'):
            print("Exiting without saving.")
            file_name = None
            break

    # Release the webcam and close windows
    cap.release()
    cv2.destroyAllWindows()

    return file_name

# Function to encode the image in Base64
def encode_image(file_name):
    try:
        with open(file_name, "rb") as image_file:
            return base64.b64encode(image_file.read()).decode('utf-8')
    except FileNotFoundError:
        print("File not found. Please capture or provide a valid image.")
        return None

# Function to upload the image to the API
def upload_to_api(encoded_image):
    conn = http.client.HTTPSConnection("skin-analyze.p.rapidapi.com")

    # Payload with the Base64 encoded image
    payload = f"image_base64={encoded_image}"

    # API headers
    headers = {
        'x-rapidapi-key': "a15f83b1a8msh33b7d7337adc054p15a242jsne02364879199",
        'x-rapidapi-host': "skin-analyze.p.rapidapi.com",
        'Content-Type': "application/x-www-form-urlencoded"
    }

    try:
        conn.request("POST", "/facebody/analysis/skinanalyze", payload, headers)
        res = conn.getresponse()
        data = res.read()
        print("API Response:", data.decode("utf-8"))
    except Exception as e:
        print("An error occurred while connecticdng to the API:", e)
    finally:
        conn.close()

# Main execution flow
if __name__ == "__main__":
    # Step 1: Capture an image
    file_name = capture_image("captured_image.jpg")

    if file_name:
        # Step 2: Encode the image
        encoded_image = encode_image(file_name)

        if encoded_image:
            # Step 3: Upload the image to the API
            upload_to_api(encoded_image)
