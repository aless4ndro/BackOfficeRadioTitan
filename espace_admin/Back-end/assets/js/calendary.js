// month abbreviations
const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

// get current date values
const currentDate = new Date();
const currentYear = currentDate.getFullYear();
const currentMonth = currentDate.getMonth() + 1; // getMonth() renvoie une valeur de 0 à 11, donc vous devez ajouter 1
const currentDay = currentDate.getDate();

// format the date string in 'Y-m-d'
let formattedDate = currentYear + '-' + (currentMonth < 10 ? '0' : '') + currentMonth + '-' + (currentDay < 10 ? '0' : '') + currentDay;

let url = "http://localhost:8080/createEvent.php?date=" + formattedDate; // add the date to the URL



// set month and year
document.querySelector('.calendar__month').innerText = months[currentDate.getMonth()];// prend le mois actuel (currentDate.getMonth()) et le transforme en abréviation (months[currentDate.getMonth()])
document.querySelector('.calendar__year').innerText = currentYear;// prend l'année actuelle (currentYear)

// create grid of days
let daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();// prend le nombre de jours dans le mois actuel (currentMonth + 1) et l'année actuelle (currentYear) et le jour 0 (le dernier jour du mois précédent)
let week = document.createElement('div');// crée un div
week.classList.add('calendar__day-numbers-row');// ajoute la classe calendar__day-numbers-row au div

for (i = 1; i <= daysInMonth; i++) {// boucle qui va de 1 au nombre de jours dans le mois actuel
	let day = document.createElement('span');// crée un span
	day.classList.add('calendar__day-number');// ajoute la classe calendar__day-number au span
	day.innerText = i;// ajoute le numéro du jour au span
	(i == currentDay) && day.classList.add('calendar__day-number--current');// si le jour actuel est égal au jour de la boucle, ajoute la classe calendar__day-number--current au span
	week.append(day);// ajoute le span au div
	
	if (new Date(currentYear, currentMonth, i).getDay() == 6 || i == daysInMonth) {// si le jour de la boucle est un samedi ou si le jour de la boucle est le dernier jour du mois
		document.querySelector('.calendar__day-numbers').append(week);// ajoute le div au div calendar__day-numbers
		
		if (i != daysInMonth) {// si le jour de la boucle n'est pas le dernier jour du mois
			week = document.createElement('div');// crée un div
			week.classList.add('calendar__day-numbers-row');// ajoute la classe calendar__day-numbers-row au div
		}
	}
}
document.querySelectorAll('.calendar__day-number').forEach(day => {
    day.addEventListener('click', () => {
        const dayFormatted = day.innerText.padStart(2, '0');// padStart(2, '0') ajoute un 0 devant le jour si le jour est inférieur à 10
        const monthFormatted = (currentMonth + 1).toString().padStart(2, '0');
        const date = `${currentYear}-${monthFormatted}-${dayFormatted}`;
        window.location.href = `/espace_admin/createEvent.php?date=${date}`;  // ajoute la date au lien
    });
});


const dayNumbers = document.querySelector('.calendar__day-numbers');
