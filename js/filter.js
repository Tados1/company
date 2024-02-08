const input = document.querySelector(".filter-input");
const allOneMachine = document.querySelectorAll(".one-machine");
const allOneMachineArray = Array.from(allOneMachine);
const allMachinesDiv = document.querySelector(".all-machines");

const machinesObjects = allOneMachineArray.map((oneMachine, index) => {
    return {
        id: index,
        machineHTML: oneMachine.innerHTML.toLowerCase()
    };
});

input.addEventListener("input", () => {
    const inputText = input.value.toLowerCase();
    const filteredMachines = machinesObjects.filter((oneMachine) => {
        return oneMachine.machineHTML.includes(inputText);
    });

    allMachinesDiv.innerHTML = "";

    filteredMachines.map((oneMachine) => {
        const newDiv = document.createElement("div");
        newDiv.classList.add("one-machine");

        newDiv.innerHTML = oneMachine.machineHTML;

        allMachinesDiv.append(newDiv);
    });
});