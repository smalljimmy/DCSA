json = PAGE
json {
  config {
    disableAllHeaderCode = 1
    disablePrefixComment = 1
    additionalHeaders = Content-type:application/json
    xhtml_cleaning = 0
    admPanel = 0
    debug = 0
    no_cache = 1
  }
  10 = TEXT
  10 < styles.content.get
}

tt_content.stdWrap.innerWrap >

