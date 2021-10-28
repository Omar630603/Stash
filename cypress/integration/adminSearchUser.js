describe("Admin Search User", () => {
    it("Search User", () => {
        cy.visit("/login");
        cy.get("#login").type("Omar").should("have.value", "Omar");
        cy.get("#password")
            .type("fakePassword")
            .should("have.value", "fakePassword");
        cy.get("#login-btn").click();
        cy.visit("/admin/orders");
        cy.get(".search-bar").type("Omar");
        cy.get("button > .fa").click();
        cy.get(".containerV > .headerVehiclesSchedules > .btn").click();
        cy.get(
            "#addUserForm > .container > :nth-child(2) > :nth-child(1) > .input-group > .form-floating > .form-control"
        ).type("Omar User Al-Maktary");
        cy.get(
            "#addUserForm > .container > :nth-child(2) > :nth-child(2) > .input-group > .form-floating > .form-control"
        ).type("Omar630603User");
        cy.get(
            "#addUserForm > .container > :nth-child(3) > :nth-child(1) > .input-group > .form-floating > .form-control"
        ).type("omar.yem1111User@email.com");
        cy.get(
            "#addUserForm > .container > :nth-child(3) > :nth-child(2) > .input-group > .form-floating > .form-control"
        ).type("+62082123533955");
        cy.get(
            ":nth-child(4) > :nth-child(1) > .input-group > .form-floating > .form-control"
        ).type("Suhat");
        cy.get(
            ":nth-child(4) > :nth-child(2) > .input-group > .form-floating > .form-control"
        ).type("user123456");
        cy.get(".btn-outline-primary").click();
        cy.visit("/admin/orders");
        cy.get(".search-bar").type("Omar630603User");
        cy.get("button > .fa").click();
    });
});
