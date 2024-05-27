// VALIDATE NUMBER INPUT FIELD
function formatNumber(input) {
    let value = input.value.replace(/[^0-9.]/g, "");
    let parts = value.split(".");
    let integerPart = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    let decimalPart = parts[1] ? "." + parts[1].slice(0, 2) : "";
    let formattedValue = integerPart + decimalPart;
    input.value = formattedValue;
}

// GET BASE AMOUNT OF SELECTED FACILITY
document.getElementById("seledtechcf").addEventListener("change", function () {
    var selectedOption = this.options[this.selectedIndex];
    var baseAmount = selectedOption.getAttribute("data-base-amount");
    if (
        !baseAmount ||
        baseAmount.trim() === "" ||
        baseAmount.trim().toUpperCase() === "NO DATA FOUND"
    ) {
        baseAmount = "0";
    } else {
        baseAmount = parseFloat(baseAmount).toFixed(2);
        baseAmount = baseAmount.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    document.getElementById("baseamount").value = baseAmount;
});

// SCRIPT FOR EDIT CONTRACT
function EditContract(conid, amount, transcode, hcfid) {
    var hcfidObject = JSON.parse(hcfid);
    var hcfname = hcfidObject.hcfname;
    var hcfcode = hcfidObject.hcfcode;
    document.getElementsByName("e_conid")[0].setAttribute("value", conid);
    document.getElementsByName("e_amount")[0].setAttribute("value", amount);
    document
        .getElementsByName("e_transcode")[0]
        .setAttribute("value", transcode);
    document.getElementsByName("hcpn")[0].setAttribute("value", hcfname);
    document
        .getElementsByName("e_controlnumber")[0]
        .setAttribute("value", hcfcode);
}

// DATE FORMAT
function formatDate(dateString) {
    var date = new Date(dateString);
    return date.toLocaleDateString("en-US", {
        month: "short",
        day: "numeric",
        year: "numeric",
    });
}

function EditContractStatus(conid, hcf, contract) {
    var hcfObject = JSON.parse(hcf);
    var hcfname = hcfObject.hcfname;
    document.getElementsByName("es_conid")[0].setAttribute("value", conid);
    document.getElementsByName("es_hcpn")[0].setAttribute("value", hcfname);
    document.getElementsByName("contract")[0].setAttribute("value", contract);
}

function ViewTranches(conid, hcfid, amount, transcode, percentage) {
    var hcfObject = JSON.parse(hcfid);
    var hcfname = hcfObject.hcfname;
    var hcfcode = hcfObject.hcfcode;
    localStorage.setItem("getConID", conid);
    localStorage.setItem("getHCFName", hcfname);
    localStorage.setItem("getHCFCode", hcfcode);
    localStorage.setItem("getAmount", amount);
    localStorage.setItem("getTransCode", transcode);
    localStorage.setItem("getPercentage", percentage);
    window.location.href =
        "/apexassets?conid=" +
        conid +
        "&hcfname=" +
        hcfname +
        "&amount=" +
        amount +
        "&transcode=" +
        transcode +
        "&hcfcode=" +
        hcfcode +
        "&percentage=" +
        percentage;
}

function toggleDetails(transcode) {
    var detailsRow = document.getElementById(transcode + "-details");
    if (detailsRow.classList.contains("d-none")) {
        detailsRow.classList.remove("d-none");
    } else {
        detailsRow.classList.add("d-none");
    }
}
