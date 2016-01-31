import os
import sys
import cv2
import numpy as np

if __name__ == "__main__":

    # Requires path to training image folder, and image we want to find.
    # Each subfolder should be of the same subject.
   
    if len(sys.argv) < 4:
        print "USAGE: recognise.py </path/to/images> sampleImage.jpg threshold"
        sys.exit()

    # Create an Eign Face recogniser
    t = float(sys.argv[3])
    model = cv2.createEigenFaceRecognizer(threshold=t)

    # Load the model
    model.load("eigenModel.xml")

    # Read the image we're looking for
    sampleImage = cv2.imread(sys.argv[2], cv2.IMREAD_GRAYSCALE)
    sampleImage = cv2.resize(sampleImage, (256,256))

    # Look through the model and find the face it matches
    [sim_index, sim_confidence] = model.predict(sampleImage)

    # Print the similarity index and confidence level

    print "%d" % (sim_index)
    print "%.2f" % (sim_confidence)

   
