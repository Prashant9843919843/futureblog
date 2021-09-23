var comments = {
  // (A) AJAX HELPER FUNCTION
  ajax : function (data, after) {
    // (A1) DATA TO SEND
    var fdata = new FormData();
    fdata.append("pid", document.getElementById("pid").value);
    for (let k in data) { fdata.append(k, data[k]); }

    // (A2) AJAX REQUEST
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "2-ajax-comments.php");
    xhr.onload = after;
    xhr.send(fdata);
  },

  // (B) LOAD COMMENTS
  load : function () {
    comments.ajax(
      // (B1) DATA TO SEND
      { req: "show" },

      // (B2) PUT COMMENTS INTO <DIV ID="CWRAP">
      function () { document.getElementById("cwrap").innerHTML = this.response; }
    );
  },

  // (C) ADD COMMENT
  add: function () {
    comments.ajax(
      // (C1) DATA
      {
        req : "add",
        name : document.getElementById("cname").value,
        msg : document.getElementById("cmsg").value
      },

      // (C2) RELOAD COMMENTS OR SHOW ERROR MESSAGE
      function () {
        if (this.response == "OK") {
          document.getElementById("cadd").reset();
          comments.load();
        } else { alert(this.response); }
      }
    );
    return false;
  }
};
window.addEventListener("DOMContentLoaded", comments.load);
