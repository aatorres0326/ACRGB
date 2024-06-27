function EditUserLogin(userid, username, status) {
    document.getElementById("titlemodal").innerHTML =
        "Modify Login Credentials";

    document.getElementsByName("userid")[0].setAttribute("value", userid);
    document
        .getElementsByName("editusername")[0]
        .setAttribute("value", username);
    document
        .getElementsByName("editpassword")[0]
        .setAttribute("placeholder", "●●●●●●●●●●●●");
    document.getElementsByName("status")[0].setAttribute("value", status);
}

function DisplayUserDetails(userid, username, leveid) {
    localStorage.setItem("getUserId", userid);
    localStorage.setItem("getUsername", username);
    localStorage.setItem("getLevel", leveid);

    window.location.href = "/useraccess?userid=" + userid + "&leveid=" + leveid;
}

// generate a random password
function generateRandomPassword() {
    var numbers = "0123456789";
    var lowercaseLetters = "abcdefghijklmnopqrstuvwxyz";
    var uppercaseLetters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    var symbols = "!@#$";

    var password = "";

    password += numbers.charAt(Math.floor(Math.random() * numbers.length));
    password += lowercaseLetters.charAt(
        Math.floor(Math.random() * lowercaseLetters.length)
    );
    password += uppercaseLetters.charAt(
        Math.floor(Math.random() * uppercaseLetters.length)
    );
    password += symbols.charAt(Math.floor(Math.random() * symbols.length));

    var remainingLength = 5;
    var charset = symbols + numbers + lowercaseLetters + uppercaseLetters;
    for (var i = 0; i < remainingLength; i++) {
        var randomIndex = Math.floor(Math.random() * charset.length);
        password += charset.charAt(randomIndex);
    }

    password = shuffleString(password);

    return password;
}

function shuffleString(str) {
    var array = str.split("");
    var currentIndex = array.length;
    var temporaryValue, randomIndex;

    while (0 !== currentIndex) {
        randomIndex = Math.floor(Math.random() * currentIndex);
        currentIndex--;

        temporaryValue = array[currentIndex];
        array[currentIndex] = array[randomIndex];
        array[randomIndex] = temporaryValue;
    }

    return array.join("");
}

function resetPassword() {
    var passwordInput = document.getElementsByName("editpassword")[0];
    var newPassword = "@" + generateRandomPassword();
    passwordInput.value = newPassword;
}

function reset() {
    var passwordInput = document.getElementsByName("editpassword")[0];
    passwordInput.placeholder = "●●●●●●●●●";
    passwordInput.value = "";
}

function addLogin(did, email) {
    document.getElementById("titlemodal").innerHTML =
        "Create Login Credentials";

    document.getElementsByName("did")[0].value = did;

    document.getElementsByName("emailc")[0].value = email;

    var password = "@" + generateRandomPassword();
    document.getElementsByName("password")[0].value = password;
}

function containsUppercase(str) {
    return /[A-Z]/.test(str);
}

function containsLowercase(str) {
    return /[a-z]/.test(str);
}

function containsNumber(str) {
    return /\d/.test(str);
}

// Table manager script
$("#tablemanager").tablemanager({
    firstSort: [
        [3, 0],
        [2, 0],
        [1, "asc"],
    ],
    disable: ["last"],
    appendFilterby: true,
    dateFormat: [[4, "mm-dd-yyyy"]],
    debug: true,
    vocabulary: {
        voc_filter_by: "Filter By ",
        voc_type_here_filter: " ",
        voc_show_rows: "Show ",
    },
    pagination: true,
    showrows: [10, 15, 50, 100],
    disableFilterBy: [1],
});

// Loader
document.getElementById("content").style.display = "none";
function showContent() {
    document.getElementById("content").style.display = "block";
    document.getElementById("loading").style.display = "none";
}
window.addEventListener("load", showContent);

// Event listener for creating login
$(document).ready(function () {
    $(".create-login").click(function () {
        var userID = $(this).data("userid");
        console.log("User ID:", userID);
    });
});

// Tooltip initialization
$(function () {
    $('[data-toggle="tooltip"]').tooltip();
});

// Initialize SlimSelect for dropdowns

document.addEventListener("DOMContentLoaded", function () {
    const input = document.getElementById("searchInput");
    const table = document.getElementById("tablemanager");
    const rows = table.getElementsByTagName("tr");
    let noMatchRow = null;

    input.addEventListener("input", function () {
        const filter = input.value.toUpperCase();
        let visibleRowCount = 0;
        for (let i = 1; i < rows.length; i++) {
            if (rows[i].classList.contains("exclude-row")) {
                continue;
            }
            const cells = rows[i].getElementsByTagName("td");
            let shouldHide = true;
            for (let j = 0; j < cells.length; j++) {
                const cellText = cells[j].textContent.toUpperCase();
                if (cellText.includes(filter)) {
                    shouldHide = false;
                    break;
                }
            }
            rows[i].style.display = shouldHide ? "none" : "";
            if (!shouldHide) {
                visibleRowCount++;
            }
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const input = document.getElementById("searchInput2");
    const table = document.getElementById("tablemanager2");
    const rows = table.getElementsByTagName("tr");
    let noMatchRow = null;

    input.addEventListener("input", function () {
        const filter = input.value.toUpperCase();
        let visibleRowCount = 0;
        for (let i = 1; i < rows.length; i++) {
            if (rows[i].classList.contains("exclude-row")) {
                continue;
            }
            const cells = rows[i].getElementsByTagName("td");
            let shouldHide = true;
            for (let j = 0; j < cells.length; j++) {
                const cellText = cells[j].textContent.toUpperCase();
                if (cellText.includes(filter)) {
                    shouldHide = false;
                    break;
                }
            }
            rows[i].style.display = shouldHide ? "none" : "";
            if (!shouldHide) {
                visibleRowCount++;
            }
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const input = document.getElementById("searchInput2");
    const table = document.getElementById("tablemanager2");
    const rows = table.getElementsByTagName("tr");
    let noMatchRow = null;

    input.addEventListener("input", function () {
        const filter = input.value.toUpperCase();
        let visibleRowCount = 0;
        for (let i = 1; i < rows.length; i++) {
            if (rows[i].classList.contains("exclude-row")) {
                continue;
            }
            const cells = rows[i].getElementsByTagName("td");
            let shouldHide = true;
            for (let j = 0; j < cells.length; j++) {
                const cellText = cells[j].textContent.toUpperCase();
                if (cellText.includes(filter)) {
                    shouldHide = false;
                    break;
                }
            }
            rows[i].style.display = shouldHide ? "none" : "";
            if (!shouldHide) {
                visibleRowCount++;
            }
        }
    });
});

function toggleDetails(transcode) {
    var detailsRow = document.getElementById(transcode + "-details");

    detailsRow.classList.toggle("d-none");

    var button = document.getElementById(transcode);
    document.addEventListener("click", function (event) {
        if (
            !button.contains(event.target) &&
            !detailsRow.contains(event.target)
        ) {
            detailsRow.classList.add("d-none");
        }
    });
}
