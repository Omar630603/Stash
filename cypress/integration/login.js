describe("Login User into A user Access", () => {
    it("Login page", () => {
        cy.visit("/login");

        cy.get("#login").type("Ali123").should("have.value", "Ali123");
        cy.get("#password").type("123456789").should("have.value", "123456789");

        cy.get("#login-btn").click();
    });
});
