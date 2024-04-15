var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.display === "block") {
      content.style.display = "none";
      if (content.classList.contains("rules")) {
        this.textContent = "Show Rules";
      } else if (content.classList.contains("nameList")) {
        this.textContent = "Show Aliases";
      }
    } else {
      content.style.display = "block";
      if (content.classList.contains("rules")) {
        this.textContent = "Hide Rules";
      } else if (content.classList.contains("nameList")) {
        this.textContent = "Hide Aliases";
      }
    }
  });
}