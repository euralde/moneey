@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto">

        <!-- Cartes statistiques -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
            <div class="bg-white rounded-xl border p-4 text-center">
                <p class="text-xs text-gray-500">Total employés</p>
                <p class="text-2xl font-bold text-gray-900" id="totalEmployes">0</p>
            </div>
            <div class="bg-emerald-50 rounded-xl border border-emerald-100 p-4 text-center">
                <p class="text-xs text-emerald-600">🟢 Actifs</p>
                <p class="text-2xl font-bold text-emerald-700" id="totalActifs">0</p>
            </div>
            <div class="bg-amber-50 rounded-xl border border-amber-100 p-4 text-center">
                <p class="text-xs text-amber-600">🟡 En congé</p>
                <p class="text-2xl font-bold text-amber-700" id="totalConge">0</p>
            </div>
            <div class="bg-blue-50 rounded-xl border border-blue-100 p-4 text-center">
                <p class="text-xs text-blue-600">🔵 En télétravail</p>
                <p class="text-2xl font-bold text-blue-700" id="totalTeletravail">0</p>
            </div>
            <div class="bg-purple-50 rounded-xl border border-purple-100 p-4 text-center">
                <p class="text-xs text-purple-600">📊 Départements</p>
                <p class="text-2xl font-bold text-purple-700" id="totalDepartements">0</p>
            </div>
        </div>

        <!-- Filtres et actions -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div class="flex flex-wrap gap-3">
                <select id="statusFilter" class="px-3 py-2 border border-gray-200 rounded-lg text-sm bg-white">
                    <option value="all">Tous les statuts</option>
                    <option value="actif">🟢 Actif</option>
                    <option value="conge">🟡 En congé</option>
                    <option value="teletravail">🔵 Télétravail</option>
                    <option value="inactif">⚫ Inactif</option>
                </select>
                <select id="departmentFilter" class="px-3 py-2 border border-gray-200 rounded-lg text-sm bg-white">
                    <option value="all">Tous les départements</option>
                    <option value="IT">IT / Développement</option>
                    <option value="Marketing">Marketing</option>
                    <option value="Commercial">Commercial</option>
                    <option value="RH">Ressources Humaines</option>
                    <option value="Finance">Finance</option>
                    <option value="Logistique">Logistique</option>
                    <option value="Direction">Direction</option>
                </select>
                <input type="text" id="searchEmployee" placeholder="Rechercher..."
                    class="px-3 py-2 border border-gray-200 rounded-lg text-sm w-48">
                <button id="resetFilters"
                    class="px-3 py-2 text-gray-500 hover:text-gray-700 border border-gray-200 rounded-lg">
                    <iconify-icon icon="solar:refresh-linear" class="text-base"></iconify-icon>
                </button>
            </div>
            <button id="openEmployeeModal"
                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium shadow-sm">
                <iconify-icon icon="solar:add-circle-linear" class="text-lg"></iconify-icon>
                Ajouter un employé
            </button>
        </div>

        <!-- Liste du personnel -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-4">Employé</th>
                            <th class="px-6 py-4">Poste</th>
                            <th class="px-6 py-4">Département</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Téléphone</th>
                            <th class="px-6 py-4">Statut</th>
                            <th class="px-6 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="personnelTableBody"></tbody>
                </table>
            </div>
            <div id="emptyPersonnel" class="text-center py-12 hidden">
                <iconify-icon icon="solar:users-group-rounded-linear"
                    class="text-5xl text-gray-300 mx-auto mb-3"></iconify-icon>
                <p class="text-gray-400">Aucun employé enregistré</p>
                <p class="text-gray-300 text-xs mt-1">Cliquez sur "Ajouter un employé" pour commencer</p>
            </div>
        </div>
    </div>

    <!-- MODAL Employé (Ajouter/Modifier) -->
    <div id="employeeModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-backdrop" id="modalBackdrop"></div>
        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-lg transform transition-all duration-300 scale-95 opacity-0"
            id="modalContainer">
            <div class="flex justify-between items-center p-5 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900" id="modalTitle">Ajouter un employé</h3>
                <button id="closeModalBtn" class="text-gray-400 hover:text-gray-600">
                    <iconify-icon icon="solar:close-circle-linear" class="text-2xl"></iconify-icon>
                </button>
            </div>
            <div class="p-5 space-y-4">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Prénom <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="employeeFirstname"
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20"
                            placeholder="Prénom">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nom <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="EmployeeLastname"
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20"
                            placeholder="Nom">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Poste</label>
                        <input type="text" id="employeePosition" class="w-full px-3 py-2 border border-gray-200 rounded-lg"
                            placeholder="Ex: Développeur Front-end">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Département</label>
                        <select id="employeeDepartment" class="w-full px-3 py-2 border border-gray-200 rounded-lg">
                            <option value="IT">IT / Développement</option>
                            <option value="Marketing">Marketing</option>
                            <option value="Commercial">Commercial</option>
                            <option value="RH">Ressources Humaines</option>
                            <option value="Finance">Finance</option>
                            <option value="Logistique">Logistique</option>
                            <option value="Direction">Direction</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="employeeEmail" class="w-full px-3 py-2 border border-gray-200 rounded-lg"
                            placeholder="prenom.nom@afroplume.com">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                        <input type="tel" id="employeePhone" class="w-full px-3 py-2 border border-gray-200 rounded-lg"
                            placeholder="+225 XX XX XX XX">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date d'embauche</label>
                        <input type="date" id="employeeHireDate" class="w-full px-3 py-2 border border-gray-200 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                        <select id="employeeStatus" class="w-full px-3 py-2 border border-gray-200 rounded-lg">
                            <option value="actif">🟢 Actif</option>
                            <option value="conge">🟡 En congé</option>
                            <option value="teletravail">🔵 Télétravail</option>
                            <option value="inactif">⚫ Inactif</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Compétences / Notes</label>
                    <textarea id="employeeSkills" rows="2"
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg resize-none"
                        placeholder="React, Node.js, Gestion d'équipe..."></textarea>
                </div>
            </div>
            <div class="flex justify-end gap-3 p-5 border-t border-gray-100 bg-gray-50/50 rounded-b-xl">
                <button id="cancelModalBtn"
                    class="px-4 py-2 text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50">Annuler</button>
                <button id="saveEmployeeBtn"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Enregistrer</button>
            </div>
        </div>
    </div>

    <!-- MODAL Changement de statut (rapide) -->
    <div id="statusModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-backdrop" id="statusModalBackdrop"></div>
        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-sm transform transition-all duration-300 scale-95 opacity-0"
            id="statusModalContainer">
            <div class="flex justify-between items-center p-5 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Changer le statut</h3>
                <button id="closeStatusModalBtn" class="text-gray-400 hover:text-gray-600">
                    <iconify-icon icon="solar:close-circle-linear" class="text-2xl"></iconify-icon>
                </button>
            </div>
            <div class="p-5 space-y-4">
                <p class="text-sm text-gray-600" id="statusEmployeeName">Chargement...</p>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nouveau statut</label>
                    <div class="space-y-2">
                        <label
                            class="flex items-center gap-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                            <input type="radio" name="newStatus" value="actif" class="w-4 h-4 text-emerald-600">
                            <span class="text-sm">🟢 Actif</span>
                        </label>
                        <label
                            class="flex items-center gap-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                            <input type="radio" name="newStatus" value="conge" class="w-4 h-4 text-amber-600">
                            <span class="text-sm">🟡 En congé</span>
                        </label>
                        <label
                            class="flex items-center gap-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                            <input type="radio" name="newStatus" value="teletravail" class="w-4 h-4 text-blue-600">
                            <span class="text-sm">🔵 Télétravail</span>
                        </label>
                        <label
                            class="flex items-center gap-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                            <input type="radio" name="newStatus" value="inactif" class="w-4 h-4 text-gray-600">
                            <span class="text-sm">⚫ Inactif</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="flex justify-end gap-3 p-5 border-t border-gray-100 bg-gray-50/50 rounded-b-xl">
                <button id="cancelStatusBtn"
                    class="px-4 py-2 text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50">Annuler</button>
                <button id="confirmStatusBtn"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Appliquer</button>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Données initiales
            let personnel = JSON.parse(localStorage.getItem('afro_personnel') || JSON.stringify([
                {
                    id: 1, firstname: "Marc", lastname: "Dupont", position: "Développeur Front-end",
                    department: "IT", email: "marc.dupont@afroplume.com", phone: "+225 07 12 34 56",
                    status: "actif", hireDate: "2024-01-15", skills: "React, TypeScript, TailwindCSS"
                },
                {
                    id: 2, firstname: "Koffi", lastname: "Jean", position: "Développeur Backend",
                    department: "IT", email: "koffi.jean@afroplume.com", phone: "+225 05 98 76 54",
                    status: "actif", hireDate: "2024-02-01", skills: "Node.js, Python, MongoDB"
                },
                {
                    id: 3, firstname: "Aïssata", lastname: "Diallo", position: "Chef de projet",
                    department: "Direction", email: "aissata.diallo@afroplume.com", phone: "+225 01 23 45 67",
                    status: "teletravail", hireDate: "2023-06-10", skills: "Agile, Scrum, Gestion d'équipe"
                },
                {
                    id: 4, firstname: "Pauline", lastname: "Yao", position: "Responsable Marketing",
                    department: "Marketing", email: "pauline.yao@afroplume.com", phone: "+225 07 89 01 23",
                    status: "actif", hireDate: "2023-09-20", skills: "SEO, Réseaux sociaux, Stratégie digitale"
                },
                {
                    id: 5, firstname: "Amadou", lastname: "Koné", position: "Commercial",
                    department: "Commercial", email: "amadou.kone@afroplume.com", phone: "+225 04 56 78 90",
                    status: "conge", hireDate: "2024-03-05", skills: "Négociation, Prospection, Fidélisation"
                }
            ]));

            let currentEditId = null;
            let currentStatusEmployeeId = null;

            const statusLabels = {
                actif: { label: "🟢 Actif", color: "bg-emerald-100 text-emerald-700" },
                conge: { label: "🟡 En congé", color: "bg-amber-100 text-amber-700" },
                teletravail: { label: "🔵 Télétravail", color: "bg-blue-100 text-blue-700" },
                inactif: { label: "⚫ Inactif", color: "bg-gray-100 text-gray-600" }
            };

            function savePersonnel() { localStorage.setItem('afro_personnel', JSON.stringify(personnel)); }

            function updateStats() {
                document.getElementById('totalEmployes').innerText = personnel.length;
                document.getElementById('totalActifs').innerText = personnel.filter(p => p.status === 'actif').length;
                document.getElementById('totalConge').innerText = personnel.filter(p => p.status === 'conge').length;
                document.getElementById('totalTeletravail').innerText = personnel.filter(p => p.status === 'teletravail').length;
                const uniqueDepts = new Set(personnel.map(p => p.department));
                document.getElementById('totalDepartements').innerText = uniqueDepts.size;
            }

            function getInitials(firstname, lastname) {
                return (firstname?.charAt(0) || '') + (lastname?.charAt(0) || '');
            }

            function renderPersonnel() {
                let filtered = [...personnel];
                const statusVal = document.getElementById('statusFilter').value;
                const deptVal = document.getElementById('departmentFilter').value;
                const searchVal = document.getElementById('searchEmployee').value.toLowerCase();

                if (statusVal !== 'all') filtered = filtered.filter(p => p.status === statusVal);
                if (deptVal !== 'all') filtered = filtered.filter(p => p.department === deptVal);
                if (searchVal) filtered = filtered.filter(p =>
                    p.firstname.toLowerCase().includes(searchVal) ||
                    p.lastname.toLowerCase().includes(searchVal) ||
                    p.position.toLowerCase().includes(searchVal) ||
                    p.email.toLowerCase().includes(searchVal)
                );

                const tbody = document.getElementById('personnelTableBody');
                const empty = document.getElementById('emptyPersonnel');

                if (filtered.length === 0) {
                    tbody.innerHTML = '';
                    empty.classList.remove('hidden');
                    updateStats();
                    return;
                }
                empty.classList.add('hidden');

                tbody.innerHTML = filtered.map(p => `
                                                                <tr class="hover:bg-gray-50 transition-colors fade-in">
                                                                    <td class="px-6 py-4">
                                                                        <div class="flex items-center gap-3">
                                                                            <div class="w-9 h-9 rounded-full avatar-placeholder flex items-center justify-center text-white text-xs font-medium shadow-sm">${getInitials(p.firstname, p.lastname)}</div>
                                                                            <div>
                                                                                <div class="font-medium text-gray-900">${escapeHtml(p.firstname)} ${escapeHtml(p.lastname)}</div>
                                                                                <div class="text-xs text-gray-400">ID: ${p.id}</div>
                                                                            </div>
                                                                        </div>
                                                                     </td>
                                                                    <td class="px-6 py-4">
                                                                        <div class="text-gray-900">${escapeHtml(p.position)}</div>
                                                                     </td>
                                                                    <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">${escapeHtml(p.department)}</span></td>
                                                                    <td class="px-6 py-4 text-gray-500">${escapeHtml(p.email)}</td>
                                                                    <td class="px-6 py-4 text-gray-500">${escapeHtml(p.phone)}</td>
                                                                    <td class="px-6 py-4">
                                                                        <div class="flex items-center gap-2">
                                                                            <span class="status-badge inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium ${statusLabels[p.status]?.color || 'bg-gray-100'}">${statusLabels[p.status]?.label || p.status}</span>
                                                                            <button onclick="openStatusModal(${p.id})" class="text-gray-400 hover:text-blue-500 transition-colors" title="Changer le statut">
                                                                                <iconify-icon icon="solar:refresh-linear" class="text-sm"></iconify-icon>
                                                                            </button>
                                                                        </div>
                                                                     </td>
                                                                    <td class="px-6 py-4 text-center">
                                                                        <div class="flex items-center justify-center gap-2">
                                                                            <button onclick="viewEmployeeDetails(${p.id})" class="text-indigo-600 hover:bg-indigo-50 p-1.5 rounded" title="Voir détails">
                                                                                <iconify-icon icon="solar:eye-linear" class="text-base"></iconify-icon>
                                                                            </button>
                                                                            <button onclick="editEmployee(${p.id})" class="text-blue-600 hover:bg-blue-50 p-1.5 rounded" title="Modifier">
                                                                                <iconify-icon icon="solar:pen-2-linear" class="text-base"></iconify-icon>
                                                                            </button>
                                                                            <button onclick="deleteEmployee(${p.id})" class="text-rose-600 hover:bg-rose-50 p-1.5 rounded" title="Supprimer">
                                                                                <iconify-icon icon="solar:trash-bin-trash-linear" class="text-base"></iconify-icon>
                                                                            </button>
                                                                        </div>
                                                                     </td>
                                                                </tr>
                                                            `).join('');
                updateStats();
            }

            function escapeHtml(str) { if (!str) return ''; return str.replace(/[&<>]/g, function (m) { if (m === '&') return '&amp;'; if (m === '<') return '&lt;'; if (m === '>') return '&gt;'; return m; }); }

            function viewEmployeeDetails(id) {
                const emp = personnel.find(p => p.id === id);
                if (emp) {
                    alert(`📋 FICHE EMPLOYÉ\n\nNom: ${emp.firstname} ${emp.lastname}\nPoste: ${emp.position}\nDépartement: ${emp.department}\nEmail: ${emp.email}\nTél: ${emp.phone}\nStatut: ${statusLabels[emp.status]?.label}\nDate embauche: ${emp.hireDate || 'Non renseignée'}\nCompétences: ${emp.skills || 'Non renseignées'}`);
                }
            }

            function editEmployee(id) {
                const emp = personnel.find(p => p.id === id);
                if (emp) {
                    currentEditId = id;
                    document.getElementById('modalTitle').innerText = 'Modifier l\'employé';
                    document.getElementById('employeeFirstname').value = emp.firstname;
                    document.getElementById('EmployeeLastname').value = emp.lastname;
                    document.getElementById('employeePosition').value = emp.position;
                    document.getElementById('employeeDepartment').value = emp.department;
                    document.getElementById('employeeEmail').value = emp.email;
                    document.getElementById('employeePhone').value = emp.phone;
                    document.getElementById('employeeHireDate').value = emp.hireDate || '';
                    document.getElementById('employeeStatus').value = emp.status;
                    document.getElementById('employeeSkills').value = emp.skills || '';
                    openModal();
                }
            }

            function deleteEmployee(id) {
                if (confirm('⚠️ Supprimer cet employé ? Cette action est irréversible.')) {
                    personnel = personnel.filter(p => p.id !== id);
                    savePersonnel();
                    renderPersonnel();
                }
            }

            function openStatusModal(id) {
                const emp = personnel.find(p => p.id === id);
                if (emp) {
                    currentStatusEmployeeId = id;
                    document.getElementById('statusEmployeeName').innerHTML = `<strong>${emp.firstname} ${emp.lastname}</strong><br><span class="text-gray-400 text-xs">Statut actuel: ${statusLabels[emp.status]?.label}</span>`;

                    document.querySelectorAll('input[name="newStatus"]').forEach(radio => {
                        radio.checked = (radio.value === emp.status);
                    });

                    const modal = document.getElementById('statusModal');
                    const container = document.getElementById('statusModalContainer');
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                    setTimeout(() => {
                        container.classList.remove('scale-95', 'opacity-0');
                        container.classList.add('scale-100', 'opacity-100');
                    }, 10);
                }
            }

            function closeStatusModal() {
                const container = document.getElementById('statusModalContainer');
                container.classList.remove('scale-100', 'opacity-100');
                container.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    document.getElementById('statusModal').classList.add('hidden');
                    document.getElementById('statusModal').classList.remove('flex');
                    currentStatusEmployeeId = null;
                }, 200);
            }

            function confirmStatusChange() {
                if (!currentStatusEmployeeId) return;
                const selectedRadio = document.querySelector('input[name="newStatus"]:checked');
                if (!selectedRadio) {
                    alert('Veuillez sélectionner un statut');
                    return;
                }
                const newStatus = selectedRadio.value;
                const index = personnel.findIndex(p => p.id === currentStatusEmployeeId);
                if (index !== -1) {
                    personnel[index].status = newStatus;
                    savePersonnel();
                    renderPersonnel();
                }
                closeStatusModal();
            }

            function openModal() {
                const modal = document.getElementById('employeeModal');
                const container = document.getElementById('modalContainer');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setTimeout(() => {
                    container.classList.remove('scale-95', 'opacity-0');
                    container.classList.add('scale-100', 'opacity-100');
                }, 10);
            }

            function closeModal() {
                const container = document.getElementById('modalContainer');
                container.classList.remove('scale-100', 'opacity-100');
                container.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    document.getElementById('employeeModal').classList.add('hidden');
                    document.getElementById('employeeModal').classList.remove('flex');
                    currentEditId = null;
                    document.getElementById('employeeFirstname').value = '';
                    document.getElementById('EmployeeLastname').value = '';
                    document.getElementById('employeePosition').value = '';
                    document.getElementById('employeeDepartment').value = 'IT';
                    document.getElementById('employeeEmail').value = '';
                    document.getElementById('employeePhone').value = '';
                    document.getElementById('employeeHireDate').value = '';
                    document.getElementById('employeeStatus').value = 'actif';
                    document.getElementById('employeeSkills').value = '';
                    document.getElementById('modalTitle').innerText = 'Ajouter un employé';
                }, 200);
            }

            function saveEmployee() {
                const firstname = document.getElementById('employeeFirstname').value.trim();
                const lastname = document.getElementById('EmployeeLastname').value.trim();
                if (!firstname || !lastname) { alert('Veuillez saisir le prénom et le nom'); return; }

                const position = document.getElementById('employeePosition').value.trim();
                const department = document.getElementById('employeeDepartment').value;
                const email = document.getElementById('employeeEmail').value.trim();
                const phone = document.getElementById('employeePhone').value.trim();
                const hireDate = document.getElementById('employeeHireDate').value;
                const status = document.getElementById('employeeStatus').value;
                const skills = document.getElementById('employeeSkills').value.trim();

                if (currentEditId !== null) {
                    const index = personnel.findIndex(p => p.id === currentEditId);
                    if (index !== -1) {
                        personnel[index] = { ...personnel[index], firstname, lastname, position, department, email, phone, hireDate, status, skills };
                    }
                } else {
                    personnel.push({
                        id: Date.now(),
                        firstname, lastname, position, department, email, phone, hireDate, status, skills
                    });
                }
                savePersonnel();
                renderPersonnel();
                closeModal();
            }

            // Event listeners
            document.getElementById('openEmployeeModal').addEventListener('click', () => { currentEditId = null; openModal(); });
            document.getElementById('closeModalBtn').addEventListener('click', closeModal);
            document.getElementById('cancelModalBtn').addEventListener('click', closeModal);
            document.getElementById('modalBackdrop').addEventListener('click', closeModal);
            document.getElementById('saveEmployeeBtn').addEventListener('click', saveEmployee);

            document.getElementById('statusFilter').addEventListener('change', renderPersonnel);
            document.getElementById('departmentFilter').addEventListener('change', renderPersonnel);
            document.getElementById('searchEmployee').addEventListener('input', renderPersonnel);
            document.getElementById('resetFilters').addEventListener('click', () => {
                document.getElementById('statusFilter').value = 'all';
                document.getElementById('departmentFilter').value = 'all';
                document.getElementById('searchEmployee').value = '';
                renderPersonnel();
            });

            document.getElementById('closeStatusModalBtn').addEventListener('click', closeStatusModal);
            document.getElementById('cancelStatusBtn').addEventListener('click', closeStatusModal);
            document.getElementById('statusModalBackdrop').addEventListener('click', closeStatusModal);
            document.getElementById('confirmStatusBtn').addEventListener('click', confirmStatusChange);

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    if (!document.getElementById('employeeModal').classList.contains('hidden')) closeModal();
                    if (!document.getElementById('statusModal').classList.contains('hidden')) closeStatusModal();
                }
            });

            // Initial render
            renderPersonnel();
        </script>

        <style>
            .modal-backdrop {
                background-color: rgba(0, 0, 0, 0.5);
                backdrop-filter: blur(4px);
            }

            .fade-in {
                animation: fadeIn 0.2s ease;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(5px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .status-badge {
                transition: all 0.2s ease;
            }

            .avatar-placeholder {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
        </style>
    @endpush
@endsection