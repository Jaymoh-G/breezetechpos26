import Card from "react-bootstrap/Card";
import DataTable from "../components/Table";
import Header from "../components/Header";

const mockUsers = [
  { id: 1, name: "Admin", email: "admin@example.com", role: "Admin" },
  { id: 2, name: "Manager", email: "manager@example.com", role: "Manager" },
];

function UsersPage() {
  return (
    <div>
      <Header title="Users" />
      <Card className="shadow-sm">
        <Card.Body>
          <DataTable
            columns={[
              { header: "Name", accessor: "name" },
              { header: "Email", accessor: "email" },
              { header: "Role", accessor: "role" },
            ]}
            rows={mockUsers}
          />
        </Card.Body>
      </Card>
    </div>
  );
}

export default UsersPage;

