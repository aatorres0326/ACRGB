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

    var contractAmount = parseFloat(
        document
            .getElementById("contractamount")
            .textContent.replace(/[^0-9.-]+/g, "")
    );
    var remainingAmount = contractAmount - totalReleasedAmount;
    document.getElementById("remainingamount").textContent = numberWithCommas(
        remainingAmount.toFixed(2)
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
