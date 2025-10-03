// Tab management
function showTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active state from all tabs
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('border-blue-500', 'text-blue-600');
        button.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab content
    document.getElementById(tabName + 'Content').classList.remove('hidden');
    
    // Activate selected tab
    document.getElementById(tabName + 'Tab').classList.add('border-blue-500', 'text-blue-600');
    document.getElementById(tabName + 'Tab').classList.remove('border-transparent', 'text-gray-500');
    
    // Load data for the tab
    if (tabName === 'services') {
        loadServices();
    } else if (tabName === 'blog') {
        loadBlogPosts();
    } else if (tabName === 'arrangements') {
        loadArrangements();
    } else if (tabName === 'messages') {
        loadMessages();
    }
}

// Service management
async function loadServices() {
    try {
        const response = await fetch('/api/services.php');
        const services = await response.json();
        
        document.getElementById('servicesCount').textContent = services.length;
        
        const servicesList = document.getElementById('servicesList');
        servicesList.innerHTML = services.map(service => `
            <div class="bg-gray-50 rounded-lg p-4 flex justify-between items-center">
                <div>
                    <h4 class="font-semibold">${service.name}</h4>
                    <p class="text-sm text-gray-600">${new Date(service.service_date).toLocaleString()} • ${service.location}</p>
                </div>
                <div class="flex space-x-2">
                    <button onclick="editService(${service.id})" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition-colors">
                        <i class="fas fa-edit mr-1"></i>Edit
                    </button>
                    <button onclick="deleteService(${service.id})" class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700 transition-colors">
                        <i class="fas fa-trash mr-1"></i>Delete
                    </button>
                </div>
            </div>
        `).join('');
    } catch (error) {
        console.error('Error loading services:', error);
    }
}

function openServiceModal(service = null) {
    const modal = document.getElementById('serviceModal');
    const title = document.getElementById('serviceModalTitle');
    const form = document.getElementById('serviceForm');
    
    if (service) {
        title.textContent = 'Edit Service';
        document.getElementById('serviceId').value = service.id;
        document.getElementById('serviceName').value = service.name;
        document.getElementById('serviceDate').value = service.service_date.replace(' ', 'T');
        document.getElementById('serviceLocation').value = service.location;
        document.getElementById('serviceDescription').value = service.description;
        document.getElementById('serviceLivestream').value = service.livestream_url || '';
        document.getElementById('serviceCondolences').value = service.condolences_url || '';
    } else {
        title.textContent = 'Add New Service';
        form.reset();
        document.getElementById('serviceId').value = '';
    }
    
    modal.classList.remove('hidden');
}

function closeServiceModal() {
    document.getElementById('serviceModal').classList.add('hidden');
}

document.getElementById('serviceForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const serviceData = {
        name: document.getElementById('serviceName').value,
        service_date: document.getElementById('serviceDate').value,
        location: document.getElementById('serviceLocation').value,
        description: document.getElementById('serviceDescription').value,
        livestream_url: document.getElementById('serviceLivestream').value,
        condolences_url: document.getElementById('serviceCondolences').value
    };
    
    const serviceId = document.getElementById('serviceId').value;
    const url = '/api/services.php';
    const method = serviceId ? 'PUT' : 'POST';
    
    if (serviceId) {
        serviceData.id = serviceId;
    }
    
    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(serviceData)
        });
        
        const data = await response.json();
        
        if (response.ok) {
            closeServiceModal();
            loadServices();
            alert(data.message);
        } else {
            alert('Error: ' + data.message);
        }
    } catch (error) {
        alert('An error occurred: ' + error.message);
    }
});

async function editService(id) {
    try {
        const response = await fetch('/api/services.php');
        const services = await response.json();
        const service = services.find(s => s.id === id);
        
        if (service) {
            openServiceModal(service);
        }
    } catch (error) {
        console.error('Error loading service:', error);
    }
}

async function deleteService(id) {
    if (confirm('Are you sure you want to delete this service?')) {
        try {
            const response = await fetch('/api/services.php', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id: id })
            });
            
            const data = await response.json();
            
            if (response.ok) {
                loadServices();
                alert(data.message);
            } else {
                alert('Error: ' + data.message);
            }
        } catch (error) {
            alert('An error occurred: ' + error.message);
        }
    }
}

// Blog management (similar structure to services)
async function loadBlogPosts() {
    try {
        const response = await fetch('/api/blog.php');
        const posts = await response.json();
        
        document.getElementById('blogCount').textContent = posts.length;
        
        const blogList = document.getElementById('blogList');
        blogList.innerHTML = posts.map(post => `
            <div class="bg-gray-50 rounded-lg p-4 flex justify-between items-center">
                <div>
                    <h4 class="font-semibold">${post.title}</h4>
                    <p class="text-sm text-gray-600">${post.excerpt}</p>
                </div>
                <div class="flex space-x-2">
                    <button onclick="editBlogPost(${post.id})" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition-colors">
                        <i class="fas fa-edit mr-1"></i>Edit
                    </button>
                    <button onclick="deleteBlogPost(${post.id})" class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700 transition-colors">
                        <i class="fas fa-trash mr-1"></i>Delete
                    </button>
                </div>
            </div>
        `).join('');
    } catch (error) {
        console.error('Error loading blog posts:', error);
    }
}

function openBlogModal(post = null) {
    const modal = document.getElementById('blogModal');
    const title = document.getElementById('blogModalTitle');
    const form = document.getElementById('blogForm');
    
    if (post) {
        title.textContent = 'Edit Blog Post';
        document.getElementById('blogId').value = post.id;
        document.getElementById('blogTitle').value = post.title;
        document.getElementById('blogExcerpt').value = post.excerpt;
        document.getElementById('blogContent').value = post.content;
    } else {
        title.textContent = 'Add New Blog Post';
        form.reset();
        document.getElementById('blogId').value = '';
    }
    
    modal.classList.remove('hidden');
}

function closeBlogModal() {
    document.getElementById('blogModal').classList.add('hidden');
}

document.getElementById('blogForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const postData = {
        title: document.getElementById('blogTitle').value,
        excerpt: document.getElementById('blogExcerpt').value,
        content: document.getElementById('blogContent').value
    };
    
    const postId = document.getElementById('blogId').value;
    const url = '/api/blog.php';
    const method = postId ? 'PUT' : 'POST';
    
    if (postId) {
        postData.id = postId;
    }
    
    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(postData)
        });
        
        const data = await response.json();
        
        if (response.ok) {
            closeBlogModal();
            loadBlogPosts();
            alert(data.message);
        } else {
            alert('Error: ' + data.message);
        }
    } catch (error) {
        alert('An error occurred: ' + error.message);
    }
});

async function editBlogPost(id) {
    try {
        const response = await fetch('/api/blog.php');
        const posts = await response.json();
        const post = posts.find(p => p.id === id);
        
        if (post) {
            openBlogModal(post);
        }
    } catch (error) {
        console.error('Error loading blog post:', error);
    }
}

async function deleteBlogPost(id) {
    if (confirm('Are you sure you want to delete this blog post?')) {
        try {
            const response = await fetch('/api/blog.php', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id: id })
            });
            
            const data = await response.json();
            
            if (response.ok) {
                loadBlogPosts();
                alert(data.message);
            } else {
                alert('Error: ' + data.message);
            }
        } catch (error) {
            alert('An error occurred: ' + error.message);
        }
    }
}

// Arrangements and Messages management
async function loadArrangements() {
    try {
        const response = await fetch('/api/arrangements.php');
        const arrangements = await response.json();
        
        document.getElementById('arrangementsCount').textContent = arrangements.length;
        
        const arrangementsList = document.getElementById('arrangementsList');
        arrangementsList.innerHTML = arrangements.map(arrangement => `
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex justify-between items-start mb-2">
                    <h4 class="font-semibold">${arrangement.first_name} ${arrangement.last_name}</h4>
                    <span class="text-sm text-gray-500">${new Date(arrangement.created_at).toLocaleDateString()}</span>
                </div>
                <p class="text-sm text-gray-600"><strong>Service Type:</strong> ${arrangement.service_type}</p>
                <p class="text-sm text-gray-600"><strong>Phone:</strong> ${arrangement.phone}</p>
                <p class="text-sm text-gray-600"><strong>Email:</strong> ${arrangement.email}</p>
                ${arrangement.message ? `<p class="text-sm text-gray-600 mt-2"><strong>Message:</strong> ${arrangement.message}</p>` : ''}
            </div>
        `).join('');
    } catch (error) {
        console.error('Error loading arrangements:', error);
    }
}

async function loadMessages() {
    try {
        const response = await fetch('/api/messages.php');
        const messages = await response.json();
        
        document.getElementById('messagesCount').textContent = messages.length;
        
        const messagesList = document.getElementById('messagesList');
        messagesList.innerHTML = messages.map(message => `
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex justify-between items-start mb-2">
                    <h4 class="font-semibold">${message.subject}</h4>
                    <span class="text-sm text-gray-500">${new Date(message.created_at).toLocaleDateString()}</span>
                </div>
                <p class="text-sm text-gray-600"><strong>From:</strong> ${message.name} (${message.email})</p>
                <p class="text-sm text-gray-600 mt-2">${message.message}</p>
            </div>
        `).join('');
    } catch (error) {
        console.error('Error loading messages:', error);
    }
}

// Logout function
async function logout() {
    try {
        const response = await fetch('/api/auth.php', {
            method: 'DELETE'
        });
        
        window.location.href = 'login.php';
    } catch (error) {
        console.error('Error during logout:', error);
        window.location.href = 'login.php';
    }
}

// Initialize dashboard
document.addEventListener('DOMContentLoaded', function() {
    loadServices();
    loadBlogPosts();
    loadArrangements();
    loadMessages();
});