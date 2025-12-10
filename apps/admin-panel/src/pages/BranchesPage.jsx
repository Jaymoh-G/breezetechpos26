import Card from "react-bootstrap/Card";
import DataTable from "../components/Table";
import Header from "../components/Header";

const mockBranches = [
  { id: 1, name: "Main", code: "MAIN", phone: "555-0123" },
  { id: 2, name: "Downtown", code: "DTN", phone: "555-0456" },
];

function BranchesPage() {
  return (
    <div>
      <Header title="Branches" />
      <Card className="shadow-sm">
        <Card.Body>
          <DataTable
            columns={[
              { header: "Name", accessor: "name" },
              { header: "Code", accessor: "code" },
              { header: "Phone", accessor: "phone" },
            ]}
            rows={mockBranches}
          />
        </Card.Body>
      </Card>
    </div>
  );
}

export default BranchesPage;

