describe("Login User into A user Access", () => {
    it("Login page", () => {
        cy.visit("/login");

        cy.get("#login")
            .type("fakeUsername")
            .should("have.value", "fakeUsername");
        cy.get("#password")
            .type("fakePassword")
            .should("have.value", "fakePassword");

        cy.get("#login-btn").click();
    });
});
