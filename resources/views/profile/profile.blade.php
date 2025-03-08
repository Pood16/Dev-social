<x-app-layout>
    <div class="min-h-screen flex flex-col">
      <!-- Profile Header -->
      <div class="relative">

        <!-- Cover Photo -->
        <div class="relative w-full h-64 overflow-hidden rounded">
          <!-- Cover Image -->
          @empty($user->cover_picture)
           <img src="https://codetheweb.blog/assets/img/posts/css-advanced-background-images/cover.jpg" alt="Cover Picture" class="w-full h-full object-cover">
          @else
           <img src="{{Storage::url($user->cover_picture)}}" alt="Cover Picture" class="w-full h-full object-cover">
          @endempty
          <!-- Form for Uploading New Cover -->
          <form action="{{ route('profile.cover') }}" method="POST" enctype="multipart/form-data" class="absolute inset-0 flex items-end justify-end p-4"> @csrf
            <!-- Styled File Input -->
            <input type="file" name="cover_image" id="cover_image" class="hidden" onchange="this.form.submit()">
            <label for="cover_image" class="cursor-pointer bg-white p-2 rounded shadow-md hover:bg-gray-100 focus:outline-none">
              <i class="fas fa-camera text-gray-600 mr-2"></i>Edit cover photo </label>
          </form>
        </div>

        <!-- Profile Info -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
          <div class="-mt-24 sm:-mt-32 sm:flex sm:items-end sm:space-x-5">
            <div class="relative group">
              <form action="{{route('profile.self')}}" method="POST" enctype="multipart/form-data" class="relative w-fit"> @csrf
                <!-- Profile Picture Container -->
                <div class="h-32 w-32 sm:h-40 sm:w-40 rounded-full ring-4 ring-white overflow-hidden bg-white relative"> @empty($user->profile_picture) <img src="https://static.vecteezy.com/system/resources/thumbnails/006/487/917/small_2x/man-avatar-icon-free-vector.jpg" alt="Cover Picture" class="w-full h-full object-cover"> @else <img src="{{Storage::url($user->profile_picture)}}" alt="Cover Picture" class="w-full h-full object-cover"> @endempty <img src="{{ Storage::url($user->profile_picture) }}" alt="Profile picture" class="object-cover w-full h-full">
                  <!-- Hidden File Input -->
                  <input type="file" name="profile_image" id="profile_image" class="hidden" onchange="this.form.submit()">
                  <!-- Upload Button -->
                  <label for="profile_image" class="absolute bottom-4 right-4 text-center bg-gray-50 p-2 shadow-md cursor-pointer hover:bg-gray-100 w-10 h-10 rounded-full">
                    <i class="fas fa-camera text-gray-600"></i>
                  </label>
                </div>
              </form>
            </div>
            <div class="mt-6 sm:flex-1 sm:min-w-0 sm:flex sm:items-center sm:justify-end sm:space-x-6 sm:pb-1">
              <div class="sm:hidden md:block mt-6 min-w-0 flex-1">
                <h1 class="text-2xl font-bold text-gray-900 truncate">{{$user->name}}</h1>
                {{-- <p class="text-gray-500">Full Stack Developer</p> --}}
              </div>
              <div class="mt-6 flex flex-col justify-stretch space-y-3 sm:flex-row sm:space-y-0 sm:space-x-4">
                <a href="{{route('profile.edit')}}" type="button" class="inline-flex justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-amber-500 hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                  <i class="fas fa-pen -ml-1 mr-2"></i>
                  <span>Edit profile</span>
                </a>
              </div>
            </div>
          </div>
          <div class="hidden sm:block md:hidden mt-6 min-w-0 flex-1">
            <h1 class="text-2xl font-bold text-gray-900 truncate">{{$user->name}}</h1>
            <p class="text-gray-500">Full Stack Developer</p>
          </div>
        </div>
      </div>

      <!-- Profile Navigation -->

      <!-- Profile Content -->
      <div class="py-8 w-10/12 mx-auto px-4 sm:px-6 lg:px-8 mt-5">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
          <!-- Column 1 -->
          <div class="lg:col-span-1">
            <!-- About Me -->
            <div class="bg-white shadow rounded-lg p-6 mb-6">
              <h2 class="text-lg font-medium text-gray-900 mb-4">About</h2>
              <p class="text-gray-600 mb-4">{{$user->bio??'try to add a bio'}} </p>
              <div class="border-t border-gray-200 pt-4 mt-2">
                <dl class="divide-y divide-gray-200">
                    <div class="py-3 flex justify-between">
                        <dt class="text-sm font-medium text-gray-500">GitHub</dt>
                        <dd class="text-sm text-amber-600 hover:text-amber-700">
                          <a href="{{$user->github_url}}" class="flex items-center" target="_blank">
                            <i class="fab fa-github mr-1"></i> {{$user->name}}
                          </a>
                        </dd>
                    </div>
                  <div class="py-3 flex justify-between">
                    <dt class="text-sm font-medium text-gray-500">Location</dt>
                    <dd class="text-sm text-gray-900">Nador, idawtanan</dd>
                  </div>
                  <div class="py-3 flex justify-between">
                    <dt class="text-sm font-medium text-gray-500">Work</dt>
                    <dd class="text-sm text-gray-900">TechForward Inc.</dd>
                  </div>
                  <div class="py-3 flex justify-between">
                    <dt class="text-sm font-medium text-gray-500">Website</dt>
                    <dd class="text-sm text-amber-600 hover:text-amber-700">
                      <a href="3.90.8.127">Dev-social</a>
                    </dd>
                  </div>
                </dl>
              </div>
            </div>
          </div>

          <!-- Column 2-->
          <div class="lg:col-span-1">
            <!-- Skills -->
            <div class="bg-white shadow-2xl rounded-lg p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                  <h2 class="text-lg font-medium text-gray-900">Skills</h2>
                  <button onclick="openSkillModal()" class="text-sm text-amber-600 hover:text-amber-700">
                    <i class="fas fa-plus mr-1"></i> Add
                </button>
                <div id="skillModal" class="fixed inset-0 hidden">
                    <!-- Modal backdrop -->
                    <div class="absolute inset-0 bg-gray-900 opacity-70"></div>
                    <!-- Modal content -->
                    <div class="relative z-10 min-h-screen flex items-center justify-center p-4">
                        <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
                            <div class="p-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-medium text-gray-900">Add New Skill</h3>
                                    <button onclick="closeSkillModal()" class="text-gray-400 hover:text-gray-500">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <form action="" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="skill" class="block text-sm font-medium text-gray-700 mb-2">Skill Name</label>
                                        <input type="text" name="skill" id="skill"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                                    </div>
                                    <div class="flex justify-end gap-3">
                                        <button type="button" onclick="closeSkillModal()"
                                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                                            Cancel
                                        </button>
                                        <button type="submit"
                                            class="px-4 py-2 text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 rounded-md">
                                            Add Skill
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                <div class="flex flex-wrap gap-2">
                    @empty($user->language)
                        <span class="px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-sm">No Languages added</span>
                    @else
                        @foreach(explode(',', $user->language) as $lan)
                            <span class="px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-sm">{{ trim($lan) }}</span>
                        @endforeach
                    @endempty
                </div>
            </div>
            <!-- Projects -->

            <div class="lg:col-span-1">
                <!-- Projects -->
                <div class="bg-white shadow-2xl rounded-lg p-6 mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-medium text-gray-900">Latest Projects</h2>
                        <button onclick="openProjectModal()" class="text-sm text-amber-600 hover:text-amber-700">
                            <i class="fas fa-plus mr-1"></i> Add
                        </button>
                    </div>
                    <div class="space-y-4">
                        @forelse($user->projects ?? [] as $project)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-700">{{ $project->title }}</span>
                                <div class="flex space-x-2">
                                    <a href="{{ $project->lien_git }}" target="_blank"
                                    class="text-amber-600 hover:text-amber-700">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                    <a href="{{ $project->lien_git }}" target="_blank"
                                    class="text-gray-600 hover:text-gray-700">
                                        <i class="fab fa-github"></i>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm">No projects added yet</p>
                        @endforelse
                    </div>
                </div>
                <!-- project modal -->
                <div id="projectModal" class="fixed inset-0 hidden">
                    <!-- Modal backdrop -->
                    <div class="absolute inset-0 bg-gray-900 opacity-70"></div>

                    <!-- Modal content -->
                    <div class="relative z-10 min-h-screen flex items-center justify-center p-4">
                        <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
                            <div class="p-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-medium text-gray-900">Add New Project</h3>
                                    <button onclick="closeProjectModal()" class="text-gray-400 hover:text-gray-500">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <form action="{{route('project.store')}}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Project Title</label>
                                        <input type="text" name="title" id="title" required
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 py-2">
                                    </div>
                                    <div class="mb-4">
                                        <label for="url" class="block text-sm font-medium text-gray-700 mb-2">Project URL</label>
                                        <input type="url" name="url" id="url"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 py-2">
                                    </div>
                                    <div class="mb-4">
                                        <label for="github_url" class="block text-sm font-medium text-gray-700 mb-2">Brief description</label>
                                        <input type="text" name="description" id="github_url"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 py-2">
                                    </div>
                                    <div class="flex justify-end gap-3">
                                        <button type="button" onclick="closeProjectModal()"
                                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                                            Cancel
                                        </button>
                                        <button type="submit"
                                            class="px-4 py-2 text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 rounded-md">
                                            Add Project
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>

          <!-- Column 3-->
          <div class="lg:col-span-1">
            <!-- Connections -->
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-medium text-gray-900">Connections</h2>
                    {{-- <a href="#" class="text-sm text-amber-600 hover:text-amber-700">See all</a> --}}
                </div>
                <div id="connections-container" class="grid grid-cols-3 gap-4 min-w-1/3">
                    <!-- Connections -->
                    <div class="flex items-center justify-center">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-amber-500"></div>
                    </div>
                </div>
            </div>
          </div>

        </div>
      </div>
    </div>
    <script>
        // skills modal
        function openSkillModal() {
            document.getElementById('skillModal').classList.remove('hidden');
        }

        function closeSkillModal() {
            document.getElementById('skillModal').classList.add('hidden');
        }

        // projects modal
        function openProjectModal() {
            document.getElementById('projectModal').classList.remove('hidden');
        }

        function closeProjectModal() {
            document.getElementById('projectModal').classList.add('hidden');
        }

        // Load connections
        document.addEventListener('DOMContentLoaded', function() {
            loadConnections();
        });

        async function loadConnections() {
            try {

                const response = await fetch('/connections/accepted', {

                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }


                if (data.success) {
                    const container = document.getElementById('connections-container');

                    if (data.connections.length === 0) {
                        container.innerHTML = `
                            <div class="col-span-3 text-center text-gray-500">
                                No connections yet
                            </div>
                        `;
                        return;
                    }

                    container.innerHTML = data.connections.map(connection => {
                        const connectionUser = connection.sender_id === {{ Auth::id() }}
                            ? connection.receiver
                            : connection.sender;

                        return `
                            <div class="text-center">
                                <div class="relative group">
                                    <img class="h-16 w-16 rounded-full mx-auto object-cover"
                                        src="${connectionUser.profile_picture
                                            ? '/storage/' + connectionUser.profile_picture
                                            : '/images/default-avatar.png'}"
                                        alt="${connectionUser.name}">
                                </div>
                                <p class="mt-2 text-xs text-gray-500">${connectionUser.name}</p>
                                <a href="/profile/${connectionUser.id}"
                                    class="text-xs text-amber-600 hover:text-amber-700">
                                    View Profile
                                </a>
                            </div>
                        `;
                    }).join('');
                }
            } catch (error) {
                console.error('Error loading connections:', error);
                document.getElementById('connections-container').innerHTML = `
                    <div class="col-span-3 text-center text-red-500">
                        Failed to load connections
                    </div>
                `;
            }
        }
    </script>
  </x-app-layout>

