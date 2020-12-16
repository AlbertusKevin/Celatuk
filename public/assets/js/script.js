function darkmode() {
  const buttonDarkMode = document.getElementById("darkmode");
  const div = document.getElementById("coba");
  if (buttonDarkMode.textContent == "on") {
    div.classList.remove("darkmode");
  } else {
    div.classList.add("darkmode");
  }
}

const baseURL = "http://localhost/socialmedia/public";

$("#cari").on("keyup", function () {
  const keyword = $("#cari").val();
  const filter = $("#filter").val();
  let username = $("#username").val();
  const target = $("#search");

  if (keyword != "") {
    if (filter == "people") {
      $.ajax({
        url: `${baseURL}/search/searchByPeople`,
        data: { keyword, filter },
        method: "post",
        dataType: "json",

        success: function (data) {
          let html = "<table>";
          data.forEach((user) => {
            if (user.username != username) {
              html += `<tr>
                                <td><img src = "${baseURL}/assets/img/user/${user.username}/profile/${user.picture}" width = "100"><td>
                                <td>${user.username}</td>
                                <td><a href = "${baseURL}/user/profile/${username}/${user.username}">detail</a></td>
                            <tr>`;
            }
          });
          html += "</table>";

          target.html(html);
        },
      });
    } else {
      $.ajax({
        url: `${baseURL}/search/searchByGroup/`,
        data: { keyword, filter },
        method: "post",
        dataType: "json",

        success: function (data) {
          let html = "<table>";
          data.forEach((group) => {
            html += `<tr>
                            <td>
                                <img src = "${baseURL}/assets/img/group/${group.groupName}/profile/${group.picture}" width = "100">
                            <td>
                            <td>${group.groupName}</td>
                            <td><a href = "${baseURL}/group/homepage/${group.groupName}/${username}">detail</a></td>
                        <tr>`;
          });
          html += "</table>";

          target.html(html);
        },
      });
    }
  }
});

$(".button-bookmark").on("click", function () {
  let button = $(this);

  if (button.hasClass("bookmark")) {
    $.ajax({
      url: `${baseURL}/post/bookmark/${$(this).data("id")}/${$(this).data(
        "username"
      )}`,
      success: () => {
        $(this).removeClass("bookmark").addClass("delete-bookmark");
        $(this).children("img").attr("src", `${baseURL}/assets/images/mdi_bookmark.svg`);
      },
      error: (error) => alert(error.textContent),
    });
  }
  if (button.hasClass("delete-bookmark")) {
    $.ajax({
      url: `${baseURL}/post/delete_bookmark/${$(this).data("id")}/${$(
        this
      ).data("username")}`,
      success: () => {
        $(this).removeClass("delete-bookmark").addClass("bookmark");
        $(this).children("img").attr("src", `${baseURL}/assets/images/mdi_bookmark-outline.svg`);
      },
      error: (error) => alert(error.textContent),
    });
  }
});

$(".button-like").on("click", function () {
  if ($(this).hasClass("like")) {
    $.ajax({
      url: `${baseURL}/post/like_post/${$(this).data("id")}/${$(this).data(
        "username"
      )}`,
      success: () => {
        $(this).removeClass("like").addClass("unlike");
        $(this).children("img").attr("src", `${baseURL}/assets/images/mdi_thumb-up.svg`);
      },
    });
  }
  if ($(this).hasClass("unlike")) {
    $.ajax({
      url: `${baseURL}/post/unlike_post/${$(this).data("id")}/${$(this).data(
        "username"
      )}`,
      success: () => {
        $(this).removeClass("unlike").addClass("like");
        $(this).children("img").attr("src", `${baseURL}/assets/images/mdi_thumb-up-outline.svg`);
      },
    });
  }
  $.ajax({
    url: `${baseURL}/celatuk/changeLike/${$(this).data("id")}`,
    dataType: "json",
    success: (data) => {
      $(".like-count").html(data);
    },
  });
});

$(".button-comment").on("click", function () {
  const comment = $(`#comment-${$(this).data("id")}`).val();

  if (comment != "") {
    $.ajax({
      url: `${baseURL}/comment/send/${$(this).data("id")}/${$(this).data(
        "username"
      )}`,
      method: "post",
      data: { comment },
    });
  } else {
    alert("Tidak bisa mengirim komentar kosong!");
  }
});

$(".edit-comment").on("click", function () {
  const idComment = $(this).data("id");
  const idPost = $(this).data("idPost");
  const username = $(this).data("username");
  const comment = $(this).prev();
  const commentValue = $(this).prev().children();

  const editForm = `<input type = "text" width = "400" id = "edit-comment-${idPost}" name = "new_comment" value = "${commentValue.text()}">
    <button class = "edit-button-comment" data-id = "${idPost}" data-username = "${username}">Update</button><br>`;
  comment.html(editForm);

  $(".edit-button-comment").on("click", function () {
    const newComment = $(`#edit-comment-${$(this).data("id")}`).val();
    if (newComment != "") {
      $.ajax({
        url: `${baseURL}/comment/update/${idComment}`,
        method: "post",
        data: { newComment },
        success: () => {
          comment.html(
            `${username} : <span class = "isi-comment">${newComment}</span>`
          );
        },
      });
    } else {
      alert("Tidak bisa mengirim komentar kosong!");
    }
  });
});

$(".delete-comment").on("click", function () {
  const idComment = $(this).data("id");
  $.ajax({
    url: `${baseURL}/comment/delete/${idComment}`,
    success: () => {
      $(this).parent().remove();
    },
  });
});
