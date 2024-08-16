// Example course data
const courses = [
    {
        id: 'matematika',
        title: 'Matematika',
        description: 'Some quick example text to build on the card title and make up the bulk of the card\'s content.',
        progress: 50,
        percentage: '50% complete'
    },
    {
        id: 'bahasa-inggris',
        title: 'Bahasa Inggris',
        description: 'Some quick example text to build on the card title and make up the bulk of the card\'s content.',
        progress: 75,
        percentage: '75% complete'
    }
    // Add more course objects here
];

// Function to create a card HTML
function createCard(course) {
    return `
        <div class="col-md-6 mb-3">
            <a href="course-detail.html?id=${course.id}" class="card-link">
                <div class="card custom-card">
                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="${course.title} Image">
                    <div class="card-body">
                        <p class="card-title">${course.title}</p>
                        <p class="card-text">${course.description}</p>
                        <div class="progress mb-2">
                            <div class="progress-bar" role="progressbar" style="width: ${course.progress}%;"
                                 aria-valuenow="${course.progress}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <p class="card-persentase">${course.percentage}</p>
                    </div>
                </div>
            </a>
        </div>
    `;
}

// Function to render all cards
function renderCards() {
    const cardContainer = document.getElementById('cardContainer');
    cardContainer.innerHTML = courses.map(createCard).join('');
}

// Call renderCards when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', renderCards);
