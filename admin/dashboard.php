<?php
require_once '../includes/auth-check.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Beautiful Funerals</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <h1 class="text-xl font-bold text-gray-800">Beautiful Funerals Admin</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">Welcome, <?php echo $_SESSION['admin_username']; ?></span>
                    <button onclick="logout()" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition-colors">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 px-4">
        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <i class="fas fa-calendar text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">Upcoming Services</h3>
                        <p class="text-2xl font-semibold text-gray-900" id="servicesCount">0</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <i class="fas fa-blog text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">Blog Posts</h3>
                        <p class="text-2xl font-semibold text-gray-900" id="blogCount">0</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-lg">
                        <i class="fas fa-clipboard-list text-yellow-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">Arrangements</h3>
                        <p class="text-2xl font-semibold text-gray-900" id="arrangementsCount">0</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <i class="fas fa-envelope text-purple-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">Messages</h3>
                        <p class="text-2xl font-semibold text-gray-900" id="messagesCount">0</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="bg-white rounded-lg shadow">
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px">
                    <button onclick="showTab('services')" id="servicesTab" class="tab-button py-4 px-6 text-center border-b-2 border-blue-500 font-medium text-blue-600">
                        <i class="fas fa-calendar mr-2"></i>Services
                    </button>
                    <button onclick="showTab('blog')" id="blogTab" class="tab-button py-4 px-6 text-center border-b-2 border-transparent font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        <i class="fas fa-blog mr-2"></i>Blog
                    </button>
                    <button onclick="showTab('arrangements')" id="arrangementsTab" class="tab-button py-4 px-6 text-center border-b-2 border-transparent font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        <i class="fas fa-clipboard-list mr-2"></i>Arrangements
                    </button>
                    <button onclick="showTab('messages')" id="messagesTab" class="tab-button py-4 px-6 text-center border-b-2 border-transparent font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        <i class="fas fa-envelope mr-2"></i>Messages
                    </button>
                </nav>
            </div>

            <!-- Services Tab -->
            <div id="servicesContent" class="tab-content p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold">Manage Services</h2>
                    <button onclick="openServiceModal()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>Add Service
                    </button>
                </div>
                <div id="servicesList" class="space-y-4">
                    <!-- Services will be loaded here -->
                </div>
            </div>

            <!-- Blog Tab -->
            <div id="blogContent" class="tab-content p-6 hidden">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold">Manage Blog Posts</h2>
                    <button onclick="openBlogModal()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>Add Post
                    </button>
                </div>
                <div id="blogList" class="space-y-4">
                    <!-- Blog posts will be loaded here -->
                </div>
            </div>

            <!-- Arrangements Tab -->
            <div id="arrangementsContent" class="tab-content p-6 hidden">
                <h2 class="text-xl font-semibold mb-6">Arrangement Requests</h2>
                <div id="arrangementsList" class="space-y-4">
                    <!-- Arrangements will be loaded here -->
                </div>
            </div>

            <!-- Messages Tab -->
            <div id="messagesContent" class="tab-content p-6 hidden">
                <h2 class="text-xl font-semibold mb-6">Contact Messages</h2>
                <div id="messagesList" class="space-y-4">
                    <!-- Messages will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Service Modal -->
    <div id="serviceModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 id="serviceModalTitle" class="text-lg font-medium text-gray-900">Add New Service</h3>
                <form id="serviceForm" class="mt-4 space-y-4">
                    <input type="hidden" id="serviceId">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="serviceName" class="block text-sm font-medium text-gray-700">Deceased Name</label>
                            <input type="text" id="serviceName" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>
                        <div>
                            <label for="serviceDate" class="block text-sm font-medium text-gray-700">Service Date & Time</label>
                            <input type="datetime-local" id="serviceDate" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>
                    </div>
                    <div>
                        <label for="serviceLocation" class="block text-sm font-medium text-gray-700">Location</label>
                        <input type="text" id="serviceLocation" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                    </div>
                    <div>
                        <label for="serviceDescription" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="serviceDescription" required rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"></textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="serviceLivestream" class="block text-sm font-medium text-gray-700">Livestream URL</label>
                            <input type="url" id="serviceLivestream" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>
                        <div>
                            <label for="serviceCondolences" class="block text-sm font-medium text-gray-700">Condolences URL</label>
                            <input type="url" id="serviceCondolences" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" onclick="closeServiceModal()" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 transition-colors">Cancel</button>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">Save Service</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Blog Modal -->
    <div id="blogModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 id="blogModalTitle" class="text-lg font-medium text-gray-900">Add New Blog Post</h3>
                <form id="blogForm" class="mt-4 space-y-4">
                    <input type="hidden" id="blogId">
                    <div>
                        <label for="blogTitle" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" id="blogTitle" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                    </div>
                    <div>
                        <label for="blogExcerpt" class="block text-sm font-medium text-gray-700">Excerpt</label>
                        <textarea id="blogExcerpt" required rows="2" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"></textarea>
                    </div>
                    <div>
                        <label for="blogContent" class="block text-sm font-medium text-gray-700">Content</label>
                        <textarea id="blogContent" required rows="6" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"></textarea>
                    </div>
                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" onclick="closeBlogModal()" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 transition-colors">Cancel</button>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">Save Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="admin.js"></script>
</body>
</html>