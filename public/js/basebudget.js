function setControlNumberAndRedirect() {
    var controlNumber = document
        .getElementById("selectedValueInput")
        .value.trim();
    localStorage.setItem("controlNumber", controlNumber);
    window.location.href = "/VIEWBUDGET?controlNumber=" + controlNumber;
}

document.getElementById("selectType").addEventListener("change", function () {
    var selectType = this.value;
    var Hcpn = document.getElementById("hcpn");
    var nonApex = document.getElementById("nonapex");
    var Apex = document.getElementById("apex");
    var ApexSelect = document.getElementById("select3");
    var nonApexSelect = document.getElementById("select");
    var HcpnSelect = document.getElementById("select2");

    HcpnSelect.removeAttribute("required");
    nonApexSelect.removeAttribute("required");
    ApexSelect.removeAttribute("required");

    if (selectType === "HCPN") {
        Hcpn.style.display = "block";
        HcpnSelect.setAttribute("required", "required");
        nonApex.style.display = "none";
        Apex.style.display = "none";
    } else if (selectType === "APEX") {
        Hcpn.style.display = "none";
        nonApex.style.display = "none";
        Apex.style.display = "block";
        ApexSelect.setAttribute("required", "required");
    } else {
        Hcpn.style.display = "none";
        nonApex.style.display = "block";
        nonApexSelect.setAttribute("required", "required");
        Apex.style.display = "none";
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
document.getElementById("select").addEventListener("change", function () {
    var select = document.getElementById("select");
    var selectedOption = select.options[select.selectedIndex];
    document.getElementById("selectedValueInput").value = selectedOption.value;
});
