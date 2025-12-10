import Card from "react-bootstrap/Card";
import DataTable from "../components/Table";
import Header from "../components/Header";

const mockCustomers = [
  { id: 1, name: "Alice Doe", email: "alice@example.com", phone: "555-0100" },
  { id: 2, name: "Bob Smith", email: "bob@example.com", phone: "555-0110" },
];

function CustomersPage() {
  return (
    <div>
      <Header title="Customers" />
      <Card className="shadow-sm">
        <Card.Body>
          <DataTable
            columns={[
              { header: "Name", accessor: "name" },
              { header: "Email", accessor: "email" },
              { header: "Phone", accessor: "phone" },
            ]}
            rows={mockCustomers}
          />
        </Card.Body>
      </Card>
    </div>
  );
}

export default CustomersPage;

