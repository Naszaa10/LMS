// Example course data
const courses = [
    {
        id: 'matematika',
        title: 'Matematika',
        description: 'Details about the Matematika course.',
        topics: [
            { title: 'Topic 1', details: 'Details for Topic 1.' },
            { title: 'Topic 2', details: 'Details for Topic 2.' }
        ],
        announcements: [
            'Announcement 1',
            'Announcement 2'
        ],
        forumPosts: [
            'Forum Post 1',
            'Forum Post 2'
        ]
    },
    {
        id: 'bahasa-inggris',
        title: 'Bahasa Inggris',
        description: 'Details about the Bahasa Inggris course.',
        topics: [
            { title: 'Topic 1', details: 'Details for Topic 1.' },
            { title: 'Topic 2', details: 'Details for Topic 2.' }
        ],
        announcements: [
            'Announcement 1',
            'Announcement 2'
        ],
        forumPosts: [
            'Forum Post 1',
            'Forum Post 2'
        ]
    }
    // Add more course objects here
];

// Function to get URL parameters
function getQueryParams() {
    const params = new URLSearchParams(window.location.search);
    return {
        id: params.get('id')
    };
}

// Function to render course detail
function renderCourseDetail(course) {
    const detailContainer = document.getElementById('courseDetail');
    detailContainer.innerHTML = `
        <h1>${course.title}</h1>
        <h4>${course.description}</h4>

        <section class="mt-4">
            <h2>Topic Outline</h2>
            <div class="accordion" id="topicAccordion">
                ${course.topics.map((topic, index) => `
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading${index}">
                            <button class="accordion-button ${index === 0 ? '' : 'collapsed'}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${index}" aria-expanded="${index === 0}" aria-controls="collapse${index}">
                                ${topic.title}
                            </button>
                        </h2>
                        <div id="collapse${index}" class="accordion-collapse collapse ${index === 0 ? 'show' : ''}" aria-labelledby="heading${index}" data-bs-parent="#topicAccordion">
                            <div class="accordion-body">
                                ${topic.details}
                            </div>
                        </div>
                    </div>
                `).join('')}
            </div>
        </section>

        <section class="mt-4">
            <h2>Announcements</h2>
            <ul class="list-group">
                ${course.announcements.map(announcement => `
                    <li class="list-group-item">
                        ${announcement}
                    </li>
                `).join('')}
            </ul>
        </section>

        <section class="mt-4">
            <h2>Forum</h2>
            <ul class="list-group">
                ${course.forumPosts.map(post => `
                    <li class="list-group-item">
                        ${post}
                    </li>
                `).join('')}
            </ul>
        </section>
    `;
}

// Call functions to render course details based on URL parameter
document.addEventListener('DOMContentLoaded', () => {
    const { id } = getQueryParams();
    const course = courses.find(c => c.id === id) || {
        title: 'Course Not Found',
        description: 'No details available for this course.',
        topics: [],
        announcements: [],
        forumPosts: []
    };
    renderCourseDetail(course);
});
