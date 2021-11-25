describe("Create a new branch from the previous test register", () => {
    it("Make branch", () => {
        cy.create("App\\Models\\Branch", {
            ID_User: 4,
            branch_name: "Malang Main",
            city: "Malang",
            branch_address: "Malang, Suhat",
        });
        cy.visit("/login");
        cy.get("#login").type("Ali123").should("have.value", "Ali123");
        cy.get("#password").type("123456789").should("have.value", "123456789");

        cy.get("#login-btn").click();
        cy.visit("/branch/home").contains("Ali123");
        cy.visit("/branch/home").contains("Branch Employee");
    });
});
