#Erzeugen eines Pageobjekt in "page"
page = PAGE
 
#Zuweisen des Sytlesheet Files
page.stylesheet = fileadmin/templates/css/page.css

page.includeJS {
  datetimepicker = fileadmin/templates/js/datetimepicker.js
}
 
#Typ der Seite ist 0, hiermit können verschiedene
#Typen ausgewählt werden z.b. für eine Druckansicht
page.typeNum = 0
 
page.10 = TEMPLATE
 
#Template ist eine Datei
page.10.template = FILE

#Der Dateiname ist template.html
page.10.template.file = fileadmin/templates/html/layout/default.html
[globalVar=TSFE:page|layout=1]
page.10.template.file = fileadmin/templates/html/layout/login.html
[global]

#Den Subpart DOCUMENT BODY bearbeiten
page.10.workOnSubpart = DOCUMENT_BODY
 
#Innerhalb von Documtent Body weitere Subparts bearbeiten
page.10.subparts {
  CONTENT < styles.content.get
  MENU = COA
  MENU {
    10 = TEXT
    10.value = <div class="title">Menü</div>
    20 < lib.mainnav
    30 = TEXT
    30 {
      value = Logout
      typolink.parameter = 1
      typolink.wrap = <div class="logout">|</div>
    }
    40 = TEXT
    40 {
      value = Impressum
      typolink.parameter = 17
      typolink.wrap = <div class="logout">|</div>
    }
  }
}

#An dieser Stelle werden die Marker
#im Template (page.10) bearbeitet
 
page.10.marks {
    #Der Marker LOGO ist ein Bild
    LOGO = IMAGE
 
    #Die Datei für das Bild ist die
        #Datei logo-typo3.gif
    LOGO.file = logo-typo3.gif
     
    #Der Marker Rootline ist ein hierachisches Menü
    ROOTLINE = HMENU
    ROOTLINE.special=rootline
    ROOTLINE.special.range= 0 | -1
    ROOTLINE.1=TMENU
 
    #Die einzelnen Einträge werden durch Slashes getrennt
    ROOTLINE.1.NO.allWrap= |   /   |*| |   /   |*| |
}

