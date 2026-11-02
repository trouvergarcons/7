/**
 * ApexCorp Dashboard Interactivity
 * Real-time search, Department filtering, and Profile modal preview
 */

document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('directorySearch');
    const deptFilter = document.getElementById('departmentFilter');
    const cards = document.querySelectorAll('.person-card');
    const resultCount = document.getElementById('resultCount');
    const emptyState = document.getElementById('emptyDirectoryState');

    function filterDirectory() {
        const searchTerm = (searchInput ? searchInput.value.toLowerCase().trim() : '');
        const selectedDept = (deptFilter ? deptFilter.value.toLowerCase() : 'all');
        let visibleCount = 0;

        cards.forEach(card => {
            const name = (card.getAttribute('data-name') || '').toLowerCase();
            const email = (card.getAttribute('data-email') || '').toLowerCase();
            const designation = (card.getAttribute('data-designation') || '').toLowerCase();
            const department = (card.getAttribute('data-department') || '').toLowerCase();
            const location = (card.getAttribute('data-location') || '').toLowerCase();

            const matchesSearch = !searchTerm || 
                name.includes(searchTerm) || 
                email.includes(searchTerm) || 
                designation.includes(searchTerm) || 
                location.includes(searchTerm);

            const matchesDept = (selectedDept === 'all' || selectedDept === '') || (department === selectedDept);

            if (matchesSearch && matchesDept) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (resultCount) {
            resultCount.textContent = visibleCount;
        }

        if (emptyState) {
            emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterDirectory);
    }

    if (deptFilter) {
        deptFilter.addEventListener('change', filterDirectory);
    }

    // Modal Details Logic
    const modal = document.getElementById('profileModal');
    const closeModalBtn = document.getElementById('closeModalBtn');

    window.openProfileModal = function(userJson) {
        if (!modal) return;
        try {
            const user = typeof userJson === 'string' ? JSON.parse(userJson) : userJson;

            document.getElementById('modalName').textContent = user.fullname || '';
            document.getElementById('modalRoleBadge').textContent = (user.role || '').toUpperCase();
            document.getElementById('modalRoleBadge').className = 'badge ' + (user.role === 'admin' ? 'badge-admin' : 'badge-employee');
            document.getElementById('modalDesignation').textContent = user.designation || '';
            document.getElementById('modalDepartment').textContent = user.department || '';
            document.getElementById('modalEmail').textContent = user.email || '';
            document.getElementById('modalEmailLink').href = 'mailto:' + user.email;
            document.getElementById('modalPhone').textContent = user.phone || 'N/A';
            document.getElementById('modalPhoneLink').href = 'tel:' + user.phone;
            document.getElementById('modalLocation').textContent = user.location || '';
            document.getElementById('modalJoined').textContent = user.created_at ? new Date(user.created_at).toLocaleDateString(undefined, { year: 'numeric', month: 'long', day: 'numeric' }) : 'N/A';

            modal.classList.add('active');
        } catch (err) {
            console.error('Error opening profile modal:', err);
        }
    };

    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', () => {
            modal.classList.remove('active');
        });
    }

    if (modal) {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.remove('active');
            }
        });
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal && modal.classList.contains('active')) {
            modal.classList.remove('active');
        }
    });

    // CSV Export Handler
    window.exportDirectoryCSV = function() {
        const cards = document.querySelectorAll('.person-card');
        if (!cards.length) {
            alert('No directory records to export.');
            return;
        }

        const rows = [
            ['Full Name', 'Designation', 'Department', 'Email', 'Phone', 'Location']
        ];

        cards.forEach(card => {
            if (card.style.display !== 'none') {
                rows.push([
                    card.getAttribute('data-name') || '',
                    card.getAttribute('data-designation') || '',
                    card.getAttribute('data-department') || '',
                    card.getAttribute('data-email') || '',
                    card.querySelector('a[href^="tel:"]')?.textContent.trim() || '',
                    card.getAttribute('data-location') || ''
                ]);
            }
        });

        const csvContent = 'data:text/csv;charset=utf-8,' + rows.map(e => e.map(val => `"${val.replace(/"/g, '""')}"`).join(',')).join('\n');
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement('a');
        link.setAttribute('href', encodedUri);
        link.setAttribute('download', 'ApexCorp_Directory_Export.csv');
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    };
});
