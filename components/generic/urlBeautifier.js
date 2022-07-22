const urlArr = window.location.href.split("/");
if (urlArr.pop() == "index.php") {
    location.replace(urlArr.join("/"));
}
