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
