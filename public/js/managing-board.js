function DisplayMbDetails(mbid, mbname) {
    localStorage.setItem("getMbId", mbid);
    localStorage.setItem("getMbname", mbname);

    window.location.href = "/mbaccess?mbid=" + mbid + "&mbname=" + mbname;
}

function setupDatePicker(datePickerId, formattedDateInputId) {
    const datePicker = document.getElementById(datePickerId);
    const formattedDateInput = document.getElementById(formattedDateInputId);

    datePicker.addEventListener("change", function () {
        const selectedDate = new Date(this.value);
        const month = selectedDate.toLocaleString("default", { month: "long" });
        const day = selectedDate.getDate();
        const year = selectedDate.getFullYear();
        formattedDateInput.value = `${month} ${day}, ${year}`;
    });
}

setupDatePicker("datePicker5", "formattedDate5");
setupDatePicker("datePicker6", "formattedDate6");

document.addEventListener("DOMContentLoaded", function () {
    document
        .getElementById("openAddAccessModal")
        .addEventListener("click", function () {
            var accessIdValue = document.getElementById("accessid").value;

            document.getElementById("confirmaddaccessid").value = accessIdValue;

            var h6Elements = document.querySelectorAll("#confirmaddsubmission");

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
    'input[type="checkbox"][data-controlnumber]'
);

mbCheckboxes.forEach(function (checkbox) {
    checkbox.addEventListener("change", function () {
        var mbid = this.getAttribute("data-controlnumber");
        var textarea = document.querySelector("#add-existing-hcpn #accessid");

        if (this.checked) {
            textarea.value += mbid + ", ";
        } else {
            textarea.value = textarea.value.replace(mbid + ", ", "");
        }
    });
});
