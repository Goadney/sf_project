const switchs = document.querySelectorAll("[data-actif-id]");

switchs.forEach((element) => {
  element.addEventListener("click", (event) => {
    // const articleId = event.target.getAttribute("data-actif-id");
    //OU
    const articleId = event.target.dataset.actifId;
    switchVisiibility(articleId);
  });
});

async function switchVisiibility(id) {
  const response = await fetch(`/admin/article/switch/${id}`);

  if (response.status < 200 || response.status > 299) {
    console.error(response);
  }
}
