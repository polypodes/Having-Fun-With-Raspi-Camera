#! /bin/bash
#
# camera.sh
# Copyright (C) 2014 ronan <ronan@raspberrypi>
#
# Distributed under terms of the MIT license.
#

# @source: http://www.raspberrypi.org/documentation/usage/camera/raspicam/raspistill.md

DATE=$(date +"%Y-%m-%d_%H%M")
DIR=`dirname "$BASH_SOURCE"`
raspistill -vf -hf -o $DIR/images/$DATE.jpg
