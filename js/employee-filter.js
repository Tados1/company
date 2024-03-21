const input = document.querySelector(".search_input");
const allOneEmployee = document.querySelectorAll(".one-employee");
const allOneEmployeeArray = Array.from(allOneEmployee);
const allEmployeesDiv = document.querySelector(".all-employees");


const employeesObjects = allOneEmployeeArray.map((oneEmployee, index) => {
    const h2Content = oneEmployee.querySelector('h2').textContent;
    return {
        id: index,
        employeeHTML: oneEmployee.innerHTML,
        employeeName: h2Content
    };
});

input.addEventListener("input", () => {
    const inputText = input.value.toLowerCase();
    const filteredEmployees = employeesObjects.filter((oneEmployee) => {
        return oneEmployee.employeeName.toLowerCase().includes(inputText);
    });

    allEmployeesDiv.innerHTML = "";

    filteredEmployees.map((oneEmployee) => {
        const newDiv = document.createElement("div");
        newDiv.classList.add("one-employee");

        newDiv.innerHTML = oneEmployee.employeeHTML;

        allEmployeesDiv.append(newDiv);
    });
});

