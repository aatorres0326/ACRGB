var mbCheckboxes = document.querySelectorAll(
    'input[type="checkbox"][data-mbid]'
);

mbCheckboxes.forEach(function (checkbox) {
    checkbox.addEventListener("change", function () {
        var mbid = this.getAttribute("data-mbid");
        var textarea = document.querySelector("#add-access #accessid");

        if (this.checked) {
            textarea.value += mbid + ", ";
        } else {
            textarea.value = textarea.value.replace(mbid + ", ", "");
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    document
        .getElementById("openAddAccessModal")
        .addEventListener("click", function () {
            var accessIdValue = document.getElementById("accessid").value;

            document.getElementById("confirmaccessid").value = accessIdValue;

            var h6Elements = document.querySelectorAll("#addaccess h6");

            h6Elements.forEach(function (element) {
                var controlNumberElement = element.querySelector(
                    ".text-center.controlnumber"
                );
                if (controlNumberElement) {
                    var controlNumber = controlNumberElement.innerText.trim();
                    if (!accessIdValue.includes(controlNumber)) {
                        element.classList.add("d-none");
                    } else {
                        element.classList.remove("d-none");
                    }
                }
            });
        });
});

document.addEventListener("DOMContentLoaded", function () {
    document
        .getElementById("openRemoveAccessModal")
        .addEventListener("click", function () {
            var accessIdValue = document.getElementById("accessid").value;

            document.getElementById("confirmremoveaccessid").value =
                accessIdValue;

            var h6Elements = document.querySelectorAll("#removeaccess h6");

            h6Elements.forEach(function (element) {
                var controlNumberElement = element.querySelector(
                    ".text-center.controlnumber"
                );
                if (controlNumberElement) {
                    var controlNumber = controlNumberElement.innerText.trim();
                    if (!accessIdValue.includes(controlNumber)) {
                        element.classList.add("d-none");
                    } else {
                        element.classList.remove("d-none");
                    }
                }
            });
        });
});
