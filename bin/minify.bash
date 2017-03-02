
minify ()
{
    for FILE in `ls resources/js|grep -v ".min.js$"`; do
        FILE="resources/js/$FILE";
        MIN_FILE=${FILE/%js/min.js}

        printf "minifying $FILE... "
        curl -X POST -s --data-urlencode "input@$FILE" https://javascript-minifier.com/raw > "$MIN_FILE"
        echo "done."
    done
}

