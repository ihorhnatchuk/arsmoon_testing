<h1><?php echo $title ?></h1>

<table>
    <?php 
    $innerHtml = "<tr>
            <th>Customer Id</th>
            <th>Number of calls within the same continent</th>
            <th>Total duration of customer's calls within same continent</th>
            <th>Number of all customer's calls</th>
            <th>Total duration of all customer's calls</th>
        </tr>";
        foreach ($collection as $key => $item) {
            $innerHtml .= '<tr>';
            $innerHtml .= '<td>'.$item->customer->getId().'</td>';
            $innerHtml .= '<td>'.$item->totalCallsSameContinent.'</td>';
            $innerHtml .= '<td>'.(string) $item->totalDurationCallsSameContinent.'</td>';
            $innerHtml .= '<td>'.$item->totalCalls.'</td>';
            $innerHtml .= '<td>'.(string) $item->totalDurationCalls.'</td>';
            $innerHtml .= '</tr>';
        }

        echo $innerHtml;
    ?>
</table>