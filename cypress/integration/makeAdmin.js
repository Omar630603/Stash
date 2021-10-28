describe("Create a new Admin from the previous test register", () => {
    it("Make Admin", () => {
        cy.create("App\\Models\\Admin", {
            ID_User: 1,
            branch: "Malang Main",
            city: "Malang",
            location: "Malang, Suhat",
        });
        cy.visit("/login");
        cy.get("#login")
            .type("fakeUsername")
            .should("have.value", "fakeUsername");
        cy.get("#password")
            .type("fakePassword")
            .should("have.value", "fakePassword");

        cy.get("#login-btn").click();
        cy.visit("/home").contains("fakeUsername");
        cy.visit("/home").contains("Admin");
    });
});
