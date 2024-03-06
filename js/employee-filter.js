const input = document.querySelector(".search_input");
const allOneEmployee = document.querySelectorAll(".one-employee");
const allOneEmployeeArray = Array.from(allOneEmployee);
const allEmployeesDiv = document.querySelector(".all-employees");

const employeesObjects = allOneEmployeeArray.map((oneEmployee, index) => {
    return {
        id: index,
        employeeHTML: oneEmployee.innerHTML
    };
});

input.addEventListener("input", () => {
    const inputText = input.value.toLowerCase();
    const filteredEmployees = employeesObjects.filter((oneEmployee) => {
        return oneEmployee.employeeHTML.toLowerCase().includes(inputText);
    });

    allEmployeesDiv.innerHTML = "";

    filteredEmployees.map((oneEmployee) => {
        const newDiv = document.createElement("div");
        newDiv.classList.add("one-employee");

        newDiv.innerHTML = oneEmployee.employeeHTML;

        allEmployeesDiv.append(newDiv);
    });
});

