
// Hace aparecer y desaparecer las respuestas

var questions = document.querySelectorAll(".question");

  questions.forEach(function(question) {
    question.addEventListener("click", function() {
      var answer = this.nextElementSibling;
      if (answer.style.display === "none") {
        answer.style.display = "block";
      } else {
        answer.style.display = "none";
      }
    });
  });