#!/bin/bash
cd $(dirname $0)
curl -X GET "https://apps.studentlife.uiowa.edu/seo/feed/positions.json?&open=true" > ../../public/api/tmp/open-jobs.json
cp ../../public/api/tmp/open-jobs.json ../../public/api/open-jobs.json

curl -X GET "https://apps.studentlife.uiowa.edu/seo/feed/categories.json" > ../../public/api/tmp/categories.json
cp ../../public/api/tmp/categories.json ../../public/api/categories.json

curl -X GET "https://apps.studentlife.uiowa.edu/seo/feed/locations.json" > ../../public/api/tmp/locations.json
cp ../../public/api/tmp/locations.json ../../public/api/locations.json

curl -X GET "https://apps.studentlife.uiowa.edu/seo/feed/departments.json" > ../../public/api/tmp/departments.json
cp ../../public/api/tmp/departments.json ../../public/api/departments.json


# curl -X GET "https://apps.studentlife.uiowa.edu/seo/feed/categories.json" > categories.json
# curl -X GET "https://apps.studentlife.uiowa.edu/seo/feed/locations.json" > locations.json
