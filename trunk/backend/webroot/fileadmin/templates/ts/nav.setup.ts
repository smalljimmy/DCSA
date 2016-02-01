lib.mainnav = HMENU 
lib.mainnav {
  special = directory
  special.value = {$nav.rootPID}
    # erstes level
  1 = TMENU
  1.wrap = <ul class="menu-level1">|</ul>
  1 {
        # no state: normale Formatierung
    NO {
      wrapItemAndSub = <li>|</li>
    }
         # act state: gültig von der rootseite bis zur aktuellen Seite
    ACT = 1
    ACT {
      wrapItemAndSub = <li class="menu-level1-active">|</li>
    }
         # cur state: gültig für die aktuelle Seite
    CUR = 1
    CUR{
      wrapItemAndSub = <li class="menu-level1-current-active">|</li>
    }
         # ifsub state: gültig für seiten die unterseiten haben
    IFSUB = 1
    IFSUB {
      wrapItemAndSub = <li class="menu-level1-with-subpage">|</li>
    }
  }
}