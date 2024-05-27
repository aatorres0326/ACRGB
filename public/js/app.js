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
    var symbols = "!@#$%^&*()_+{}[];:<>,.?/";

    var password = "";

    password += numbers.charAt(Math.floor(Math.random() * numbers.length));
    password += lowercaseLetters.charAt(
        Math.floor(Math.random() * lowercaseLetters.length)
    );
    password += uppercaseLetters.charAt(
        Math.floor(Math.random() * uppercaseLetters.length)
    );
    password += symbols.charAt(Math.floor(Math.random() * symbols.length));

    var remainingLength = 4;
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

function addLogin(did, lastname) {
    var lastnamec = lastname.replace(/\s/g, "");
    document.getElementById("titlemodal").innerHTML = "Add Login Credentials";
    document.getElementsByName("did")[0].setAttribute("value", did);
    document
        .getElementsByName("userlastname")[0]
        .setAttribute("value", lastname);

    var currentDate = new Date();
    var philippinesTime = new Date(
        currentDate.toLocaleString("en-US", { timeZone: "Asia/Manila" })
    );

    var month = (philippinesTime.getMonth() + 1).toString().padStart(2, "0");
    var day = philippinesTime.getDate().toString().padStart(2, "0");
    var year = philippinesTime.getFullYear();
    var hours = philippinesTime.getHours().toString().padStart(2, "0");
    var minutes = philippinesTime.getMinutes().toString().padStart(2, "0");
    var seconds = philippinesTime.getSeconds().toString().padStart(2, "0");

    var username = lastnamec + year + month + day + hours + minutes + seconds;
    document.getElementsByName("username")[0].setAttribute("value", username);
    var password = "@" + generateRandomPassword();
    document.getElementsByName("password")[0].setAttribute("value", password);
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
new SlimSelect({
    select: "#select",
});

new SlimSelect({
    select: "#select2",
});

new SlimSelect({
    select: "#select3",
});
new SlimSelect({
    select: "#hcpn",
});
new SlimSelect({
    select: "#selectedhcf",
});

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
