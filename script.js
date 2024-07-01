document.addEventListener("DOMContentLoaded", function () {
    const sloganElement = document.getElementById("slogan");
    const sloganText = "Innovate, Organize, Inspire: Tipanni - Your Digital Notebook.";
    const typingSpeed = 100; // Adjust the typing speed in milliseconds
    const pauseDuration = 1500; // Adjust the pause duration in milliseconds
  
    function typeSlogan() {
      let index = sloganElement.innerHTML.length; // Start from the current length of the innerHTML
      let intervalId = setInterval(function () {
        sloganElement.innerHTML += sloganText[index];
        index++;
        if (index === sloganText.length) {
          clearInterval(intervalId);
          setTimeout(deleteSlogan, pauseDuration);
        }
      }, typingSpeed);
    }
  
    function deleteSlogan() {
      let index = sloganText.length - 1;
      let intervalId = setInterval(function () {
        if (index > 0) {
          sloganElement.innerHTML = sloganText.slice(0, index);
          index--;
        } else {
          clearInterval(intervalId);
          typeSlogan(); // Continue the loop without waiting
        }
      }, typingSpeed / 2);
    }
  
    typeSlogan(); // Start the typing animation
  });
  