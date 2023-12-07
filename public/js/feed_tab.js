function openTab(selectedTab) {
    var tabs = document.querySelectorAll('.tab-content');
    //console.log("aba: " + selectedTab);
    tabs.forEach(function(tab) {
      tab.style.display = 'none';
    });
  
    var activeTab = document.getElementById(selectedTab);
    activeTab.style.display = 'block';
}

document.addEventListener('DOMContentLoaded', function() {
    openTab('topQuestions');
});