const validateForm = () => {
    let fname = document.getElementById('patientName').value;
    let validate = /^[a-zA-Z\s]+$/;
    if (!validate.test(fname)) {
        alert("Invalid characters in patient name.");
        return false;
    }

    let numbers = document.querySelectorAll(".num");

    let numberValidate = /^\d+$/;

    for (let i = 0; i < numbers.length; i++) {
        if (!numberValidate.test(numbers[i].value)) {
            alert("Invalid number entered.");
            return false;
        }
    }

    return true;
}

