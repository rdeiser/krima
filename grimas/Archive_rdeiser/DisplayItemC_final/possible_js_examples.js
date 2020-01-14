    if (process == "LOAN") {
      status/*card-stat3*/ = (status == "PASS") ? "PULL-DUE" : "PULL-MULT";
      status_msg += "Item is on LOAN. ";
    } else if (process == "CLAIM RETURNED LOAN") {
      status = (status == "PASS") ? "PULL-DUE" : "PULL-MULT";
      status_msg += "Item is CLAIM RETURNED. ";
    } else if (process == "LOST LOAN") {
      status = (status == "PASS") ? "PULL-DUE" : "PULL-MULT";
      status_msg += "Item is LOST. ";
    } else {
      if (process != "") {
        status = (status == "PASS") ? "PULL-STAT" : "PULL-MULT";
        status_msg += "Item has a process status. ";
      }
    }

var COLORMAP = [
  {status: "PASS",       color: "white",        nickname: "white",           desc: "Information is valid.  No action required."},
  {status: STAT_FAIL,    color: "pink",         nickname: "pink",            desc: "Retrieval failed.  Try to refresh again.  File a ticket with LIT if the issue persists."},
  {status: "NOT-FOUND",  color: "coral",        nickname: "red",             desc: "No Alma data for barcode.  Attach flag and pull item."},
  {status: "META-CALL",  color: "darkorange",   nickname: "electric orange", desc: "Bad Call Number.  Attach flag and send to Metadata Services for correction."},
  {status: "META-TTL",   color: "lightskyblue", nickname: "blue",            desc: "Bad Title.  Attach flag and send to Metadata Services for correction."},
  {status: "META-VOL",   color: "lightgreen",   nickname: "mint green",      desc: "Bad Volume.  Attach flag and send to Metadata Services for correction."},
  {status: "PULL-STAT",  color: "goldenrod",    nickname: "goldenrod",       desc: "Incorrect process type. Attach flag and pull item.  Send to Access Services for correction."},
  {status: "PULL-LOC",   color: "yellow",       nickname: "yellow",          desc: "Incorrect location. Attach flag and pull item.  Send to Access Services for correction."},
  {status: "PULL-SUPP",  color: "tan",          nickname: "tan",             desc: "Bib is marked as suppressed. Attach flag and pull item.  Send to Access Services for correction."},
  {status: "PULL-HSUPP", color: "violet",       nickname: "purple",          desc: "Holding is suppressed. Attach flag and pull item.  Send to Access Services for correction."},
  {status: "PULL-DUE",   color: "chartreuse",   nickname: "electric green",  desc: "Item is checked out in Alma. Attach flag and pull item.  Send to Access Services for correction."},
  {status: "PULL-MULT",  color: "grey",         nickname: "grey",            desc: "Multiple problems. Attach flags and pull item.  Send to Access Services for correction."},
];