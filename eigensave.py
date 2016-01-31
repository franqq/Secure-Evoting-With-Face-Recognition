import os
import sys
import cv2
import numpy as np

def normalize(X, low, high, dtype=None):
    """Normalizes a given array in X to a value between low and high."""
    X = np.asarray(X)
    minX, maxX = np.min(X), np.max(X)
    # normalize to [0...1].
    X = X - float(minX)
    X = X / float((maxX - minX))
    # scale to [low...high].
    X = X * (high-low)
    X = X + low
    if dtype is None:
        return np.asarray(X)
    return np.asarray(X, dtype=dtype)


def read_images(path, sz=None):
    """Reads the images in a given folder, resizes images on the fly if size is given.

    Args:
        path: Path to a folder with subfolders representing the subjects (persons).
        sz: A tuple with the size Resizes

    Returns:
        A list [X,y,z]

            X: The images, which is a Python list of numpy arrays.
            y: The corresponding labels (the unique number of the subject, person) in a Python list.
    """

    X,y = [], []
    count = 0
    for dirname, dirnames, filenames in os.walk(path):
        for subdirname in dirnames:
            subject_path = os.path.join(dirname, subdirname)
            for filename in os.listdir(subject_path):
                try:
                    im = cv2.imread(os.path.join(subject_path, filename), cv2.IMREAD_GRAYSCALE)
                    # resize to given size (if given)
                    if (sz is not None):
                        im = cv2.resize(im, sz)
                    X.append(np.asarray(im, dtype=np.uint8))
                    y.append(count)
                except IOError, (errno, strerror):
                    print "I/O error({0}): {1}".format(errno, strerror)
                except:
                    print "Unexpected error:", sys.exc_info()[0]
                    raise
            count = count+1
    return [X,y]

if __name__ == "__main__":
    # You'll need at least a path to your image data. 
    # Each subfolder should be of the same subject.
    """
     Eg:
    |-path
      |-Alice
      | |-0.jpg
      | |-1.jpg
      |
      |-Bob
      | |-0.jpg
      |
      |-Carly
      ...
    """
    if len(sys.argv) < 1:
        print "USAGE: eigensave.py </path/to/images>"
        sys.exit()
    # Now read in the image data. This must be a valid path!
    [X,y] = read_images(sys.argv[1], (256,256))
    # Convert labels to 32bit integers. This is a workaround for 64bit machines,
    y = np.asarray(y, dtype=np.int32)

    # Create the Eigenfaces model.
    model = cv2.createEigenFaceRecognizer()
    # Learn the model. Remember our function returns Python lists,
    # so we use np.asarray to turn them into NumPy lists to make
    # the OpenCV wrapper happy:
    model.train(np.asarray(X), np.asarray(y))

    # Save the model for later use
    model.save("/opt/lampp/htdocs/jkuatvs/eigenModel.xml")
