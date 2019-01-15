var myTemplateConfig = {
	colors: [ "#000", "#66F", "#696" ], // branches colors, 1 per column
	branch: {
		lineWidth: 2,
		spacingX: 15,
		showLabel: false,                  // display branch names on graph
	},
	commit: {
		spacingY: -40,
		dot: {
			size: 8
		},
		message: {
			displayAuthor: true,
			displayBranch: true,
			displayHash: true,
			font: "normal 12pt Arial"
		},
	}
};
var myTemplate = new GitGraph.Template( myTemplateConfig );


var gitgraph = new GitGraph({
	template: myTemplate,
	orientation: 'vertical-reverse',
});
var master = gitgraph.branch("master");
gitgraph.commit({
	dotSize: 5,
	message: "created person class",
	author: "Carrie"
});
var newAuth = gitgraph.branch('new-auth');
newAuth.commit({
	dotSize: 5,
	message: "Added new authentication method",
	author: "Bob"
});
var rfPerson = master.branch('rf-person');
newAuth.merge(master, {
	dotSize: 5,
	message: "Merge branch 'new-auth'",
	author: "Carrie"
}).delete();
rfPerson.commit({
	dotSize: 5,
	message: "Refactor Person -> User",
	author: "Alice"
});
rfPerson.commit({
	dotSize: 5,
	message: "Replace Person everywhere",
	author: "Alice"
});
rfPerson.merge(master, {
	dotSize: 5,
	message: "Merge branch 'rf-person'",
	author: "Carrie"
}).delete();
master.commit({
	dotSize: 5,
	message: "Hotfix: Use User in new auth",
	author: "Carrie"
});

/*


* [master] Carrie: Merge branch 'rf-person'
|\
| * [rf-person] Alice: Replace Person everywhere
| * Alice: Refactor Person -> User
* |   Carrie: Merge branch 'new-auth'
|\ \
| |/
|/|
| * [new-auth] Bob: Added new authentication method
|/
* [last-release]Carrie: created person class






 */
