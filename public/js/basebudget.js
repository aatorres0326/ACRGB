function setControlNumberAndRedirect() {
    var controlNumber = document
        .getElementById("selectedValueInput")
        .value.trim();
    var DateFrom = document.getElementById("datePicker3").value;
    var DateTo = document.getElementById("datePicker4").value;
    var Facilities = document.getElementById("hcfcode").value;

    if (
        !controlNumber ||
        !DateFrom ||
        !DateTo ||
        (!Facilities &&
            document.getElementById("hcfcode").hasAttribute("required"))
    ) {
        window.alert("Please fill out all required fields.");
        return;
    }

    window.location.href =
        "/VIEWBUDGET?controlNumber=" +
        encodeURIComponent(controlNumber) +
        "&DateFrom=" +
        encodeURIComponent(DateFrom) +
        "&DateTo=" +
        encodeURIComponent(DateTo) +
        "&Facilities=" +
        encodeURIComponent(Facilities);
}

document.getElementById("selectType").addEventListener("change", function () {
    var selectType = this.value;
    var Hcpn = document.getElementById("hcpn");

    var Apex = document.getElementById("apex");
    var ApexSelect = document.getElementById("select3");

    var HcpnSelect = document.getElementById("select2");

    var facilities = document.getElementById("facilities");

    HcpnSelect.removeAttribute("required");

    ApexSelect.removeAttribute("required");
    facilities.removeAttribute("required");

    if (selectType === "HCPN") {
        Hcpn.style.display = "block";
        facilities.style.display = "block";
        HcpnSelect.setAttribute("required", "required");
        facilities.setAttribute("required", "required");
        Apex.style.display = "none";
    } else {
        Hcpn.style.display = "none";
        Apex.style.display = "block";
        facilities.style.display = "none";
        ApexSelect.setAttribute("required", "required");
    }
});

document.getElementById("select3").addEventListener("change", function () {
    var select = document.getElementById("select3");
    var selectedOption = select.options[select.selectedIndex];
    document.getElementById("selectedValueInput").value = selectedOption.value;
});
document.getElementById("select2").addEventListener("change", function () {
    var select = document.getElementById("select2");
    var selectedOption = select.options[select.selectedIndex];
    document.getElementById("selectedValueInput").value = selectedOption.value;
});
