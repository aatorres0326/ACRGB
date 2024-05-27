document.addEventListener("DOMContentLoaded", function () {
    document
        .getElementById("openRemoveAccessModal")
        .addEventListener("click", function () {
            var accessIdValue = document.getElementById("accessid").value;

            document.getElementById("confirmremoveaccessid").value =
                accessIdValue;

            var h6Elements = document.querySelectorAll(
                "#confirmremovesubmission"
            );

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

var mbCheckboxes = document.querySelectorAll(
    'input[type="checkbox"][data-hcfid]'
);

mbCheckboxes.forEach(function (checkbox) {
    checkbox.addEventListener("change", function () {
        var mbid = this.getAttribute("data-hcfid");
        var textarea = document.querySelector("#add-access #accessid");

        if (this.checked) {
            textarea.value += mbid + ", ";
        } else {
            textarea.value = textarea.value.replace(mbid + ", ", "");
        }
    });
});

window.onload = function () {
    var userid = localStorage.getItem("getMbId");
    var username = localStorage.getItem("getMbname");

    document.getElementById("putmbname").value = mbname;
    document.getElementById("putmbid").value = mbid;
    document.getElementById("inputmbid").value = mbid;
};
