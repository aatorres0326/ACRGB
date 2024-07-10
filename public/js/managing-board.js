function DisplayMbDetails(mbid, mbname) {
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

function setMinDateTo() {
    const dateFrom = document.getElementById("datePicker5").value;
    const dateTo = document.getElementById("datePicker6");
    dateTo.min = dateFrom;
}

function formatDate(dateStr) {
    const date = new Date(dateStr);
    const options = { month: "short", day: "numeric", year: "numeric" };
    return date.toLocaleDateString("en-US", options);
}

function EditHCPN(
    mbid,
    controlnumber,
    mbname,
    address,
    bankaccount,
    bankname,
    licensedatefrom,
    licensedateto
) {
    document.getElementById("hcpn-id").value = mbid;
    document.getElementById("edit-controlnumber").value = controlnumber;
    document.getElementById("edit-hcpn").value = mbname;
    document.getElementById("edit-address").value = address;
    document.getElementById("edit-bank-account").value = bankaccount;
    document.getElementById("edit-bank-name").value = bankname;
    document.getElementsByName("edit-license-date-from")[0].placeholder =
        formatDate(licensedatefrom);
    document.getElementsByName("edit-license-date-to")[0].placeholder =
        formatDate(licensedateto);
}
function RemoveHCPN(controlnumber, mbname) {
    document.getElementById("remove-controlnumber").value = controlnumber;
    document.getElementById("remove-hcpn").value = mbname;
}
function formatDate(dateStr) {
    const [month, day, year] = dateStr.split("-");
    const date = new Date(`${year}-${month}-${day}`);
    const options = { month: "short", day: "numeric", year: "numeric" };
    return date.toLocaleDateString("en-US", options);
}

function setMinDateTo() {
    const dateFrom = document.getElementById("datePicker5").value;
    const dateTo = document.getElementById("datePicker6");
    dateTo.min = dateFrom;
}
