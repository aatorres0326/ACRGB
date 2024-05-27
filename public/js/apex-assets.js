function updatePercentage() {
    var selectElement = document.getElementById("tranch");
    var selectedIndex = selectElement.selectedIndex;
    var selectedOption = selectElement.options[selectedIndex];

    var percent = "";
    var computedAmount = "";

    if (selectedOption.textContent !== "Select Tranche") {
        percent = parseFloat(selectedOption.getAttribute("data-percent"));
        var selectContract = parseFloat(
            document.getElementById("contract").value
        );
        computedAmount = (selectContract * percent) / 100;
        document.getElementById("tranch_amount").value =
            computedAmount.toFixed(2);
    } else {
        document.getElementById("tranch_amount").value = computedAmount;
    }

    document.getElementById("percent").value = percent;
}

document.addEventListener("DOMContentLoaded", function () {
    var totalReleasedAmount = 0;
    var releasedAmounts = document.querySelectorAll(
        "#assetsTable tbody tr td:nth-child(5)"
    );
    releasedAmounts.forEach(function (element) {
        totalReleasedAmount += parseFloat(
            element.textContent.replace(/[^0-9.-]+/g, "")
        );
    });
    document.getElementById("totalreleased").textContent = numberWithCommas(
        totalReleasedAmount.toFixed(2)
    );

    var selectedPercent = parseFloat(
        document.getElementById("SelectedPercent").value
    );
    var utilizedAmount = (selectedPercent / 100) * totalReleasedAmount;
    document.getElementById("utilizedamount").textContent = numberWithCommas(
        utilizedAmount.toFixed(2)
    );
});

function numberWithCommas(number) {
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

document.addEventListener("DOMContentLoaded", function () {
    sortTableByDateReleased();
});

function sortTableByDateReleased() {
    var table = document.getElementById("assetsTable");
    var tbody = table.querySelector("tbody");
    var rows = Array.from(tbody.querySelectorAll("tr"));

    rows.sort(function (rowA, rowB) {
        var dateA = new Date(rowA.cells[5].textContent);
        var dateB = new Date(rowB.cells[5].textContent);
        return dateA - dateB;
    });

    rows.forEach(function (row) {
        tbody.appendChild(row);
    });
}
