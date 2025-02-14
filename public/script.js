document.addEventListener("DOMContentLoaded", function() {
  fetch("../src/scrape.php")
    .then(response => response.json())
    .then(articles => {
      const newsList = document.getElementById("news-list");
      newsList.innerHTML = "";

      articles.forEach(article => {
        let li = document.createElement("li");
        let a = document.createElement("a");
        a.href = article.link;
        a.textContent = article.title;
        a.target - "_blank";
        li.appendChild(a);
        newsList.appendChild(li);
      });
    })
    .catch(error => console.error("Error fetching data:", error));
});